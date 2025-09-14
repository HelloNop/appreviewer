<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\MailJob;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Filament\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class SendCertificateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        $userLogin = User::find($this->data['recipient_id']); 

        try {
            $backgroundPath = storage_path('app/public/' . $this->data['journal_certificate_path']);
            $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($this->data['journal_url']));
            
            $pdfData = [
                'user' => $this->data['user_name'],
                'journal' => $this->data['journal_title'],
                'position' => $this->data['position'],
                'qrcode' => $qrcode,
                'backgroundPath' => $backgroundPath,
            ];
            
            $pdfOutput = FacadePdf::loadView('certificate.position-certificate', $pdfData)->output();
            
            $filename = 'Certificate_of_' . str_replace(' ', '_', $this->data['position']) . '_' . str_replace(' ', '_', $this->data['user_name']) . '.pdf';
            
            // Buat instance mailable dengan data saja
            $mailable = new MailJob($this->data);
            
            // Tambahkan lampiran pada instance mailable
            $mailable->attachData($pdfOutput, $filename, ['mime' => 'application/pdf']);
            
            // Kirim email menggunakan instance mailable yang sudah lengkap
            Mail::to($this->data['user_email'])->send($mailable); 

            // notificasi
            Notification::make()
                ->title('Email Sent')
                ->body('Email sent to ' . $this->data['user_email'] . ' Succesfully')
                ->success()
                ->sendToDatabase($userLogin);
        }

        catch (\Exception $e) {
            
            // Simpan log error
            Log::error('Error sending certificate email: ' . $e->getMessage());

            // Kirim notifikasi ke database
            Notification::make()
                ->title('Sending Email Failed')
                ->body('Error sending certificate email: ' . $e->getMessage())
                ->danger()
                ->sendToDatabase($userLogin); // $recipient = instance User

        }

    }
}
