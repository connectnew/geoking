<?php

namespace App\Jobs;

use App\Location;
use App\Mail\ScanResultMail;
use App\OAuth;
use App\Objects\ScanReportDetails;
use App\ScanResult;
use App\Services\ScanService;
use App\Source;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Google_Client;
use Illuminate\Support\Facades\Mail;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;
use OutOfBoundsException;

/**
 * Class ScanLocationsJob
 * @package App\Jobs
 */
class ScanLocationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int The number of seconds the job can run before timing out. */
    public $timeout = 120;

    /** @var User */
    protected $user;

    /** @var array <Location, Source>[] */
    protected $pairs = [];

    /**
     * Create a new job instance.
     * @param User $user
     * @param Location[] $locations
     * @param Source[] $sources
     */
    public function __construct(User $user, array $locations = [], array $sources = [])
    {
        if (count($locations) !== count($sources)) {
            throw new OutOfBoundsException('');
        }

        $this->user = $user;

        for ($i=0, $len = count($locations); $i<$len; $i++) {
            $this->pairs[] = [
                'Location' => $locations[$i],
                'Source' => $sources[$i]
            ];
        }
    }

    /**
     * Execute the job.
     *
     * @param ScanService $scanService
     * @param Google_Client $gClient
     * @return void
     */
    public function handle(ScanService $scanService, Google_Client $gClient): void
    {
        /** @var OAuth $oauth */
        $oauth = $this->user->oauth()->where('provider', OAuth::GOOGLE)->get()->first();
        $oauth->configureGoogle($gClient);

        $gmb = new GoogleMyBusiness($gClient);
        $scanDetails = new ScanReportDetails();

        $res = [];
        foreach ($this->pairs as ['Location'=> $location, 'Source' => $source]) {
            $report = $scanService->googleMyBusinessScan($gmb, $source, $location);
            $reportDetails = $scanDetails->makeDetails($report, [ScanService::GOOGLE_MY_BUSINESS_API_NAME]);
            $res[] = ['result' => $reportDetails, 'error' => ''];
            // save scan result
            $this->saveScanResult($location, $reportDetails);
        }

        if (null !== ($pdf = $scanDetails->makePdf(count($res)))) {
            Mail::to($this->user->email)->send(new ScanResultMail($pdf->output()));
        }
    }

    /**
     * @param Location $location
     * @param array $reportDetails
     */
    private function saveScanResult(Location $location, array $reportDetails): void
    {
        $result = new ScanResult();
        $result->location_id = $location->id;
        $result->score = $reportDetails['mean_score'];
        $result->report_details = $reportDetails;
        $result->save();
    }
}
