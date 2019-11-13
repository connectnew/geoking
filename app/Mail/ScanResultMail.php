<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ScanResultMail
 * @package App\Mail
 */
class ScanResultMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    private $pdf;

    /**
     * Create a new message instance.
     *
     * @param string $pdf
     */
    public function __construct(string $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $fileName = sprintf('result-%s.pdf', Carbon::now()->format('Ymd-Hi'));
        return $this->subject(config('app.name'))
            ->view('mails.message', ['file_name' => $fileName])
            ->attachData($this->pdf, $fileName, ['mime' => 'application/pdf']);
    }
}
