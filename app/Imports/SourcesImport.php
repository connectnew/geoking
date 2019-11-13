<?php

namespace App\Imports;

use App\Account;
use App\Source;
use App\User;
use Igaster\LaravelCities\Geo;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * Class SourcesImport
 * @package App\Imports
 */
class SourcesImport implements ToModel, WithValidation, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors;
    use SkipsFailures;

    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        /** @var Account $acc */
        $acc = $this->user->accounts()->first();

        $model = Source::where('external_id', $row['number'])
            ->where('account_id', $acc->id)
            ->first();

        $data = [
            'external_id' => $row['number'],
            'name' => $row['location_name'],
            'website' => $row['website'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'country' => $row['country'],
            'province' => $row['province'],
            'city' => $row['city'],
            'postal_code' => $row['postal_code'],
            'gmb_place_id' => $row['google_identifier'] ?? null,
        ];

        if ($model instanceof Source) {
            $model->update($data);
        } else {
            $data['account_id'] = $acc->id;
            Source::create($data);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            '*.number' => ['required', 'gte:1'],
            '*.location_name' => ['required', 'max:255'],
            '*.website' => ['required', 'max:255'],
            '*.phone' => ['required', 'regex:/^\+\d[\d\s\-\(\)]+\d$/', 'max:100'],
            '*.address' => ['required', 'max:255'],
            '*.country' => ['required', 'exists:geo,country,level,' . Geo::LEVEL_COUNTRY],
            '*.province' => ['required', 'max:255'],
            '*.city' => ['required', 'max:255'],
            '*.postal_code' => ['required', 'max:255'],
        ];
    }
}
