<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCertificatePositionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $journaluser;
    public $pdf;
    public $fileName;

    /**
     * Create a new message instance.
     */
    public function __construct($journaluser, $pdf, $fileName)
    {
        $this->journaluser = $journaluser;
        $this->pdf = $pdf; // Set pdf property with the passed value, defaulting to null if undefined
        $this->fileName = $fileName;
    }

    public function build()
    {
        return $this->subject('certificate of Contribution')
            ->view('email.certificateMail') // Ini isi body email
            ->attachData(
                $this->pdf->output(),
                $this->fileName,
                ['mime' => 'application/pdf']
            );
    }

}
