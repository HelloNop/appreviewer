<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailJob extends Mailable
{
 
    public $data;

    // Konstruktor hanya menerima $data, filename akan diatur saat attach
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Certificate of Appreciation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.certificateMail',
            with: ['data' => $this->data]
        );
    }

    // Metode attachments() dikosongkan karena akan ditambahkan di Job
    public function attachments(): array
    {
        return []; 
    }
}
