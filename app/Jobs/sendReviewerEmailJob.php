<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\MailJob;
use App\Mail\pointMailJob;
use App\Models\Point;
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

class sendReviewerEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pointId;
    protected $userLoginId;

    public function __construct($pointId, $userLoginId = null)
    {
        $this->pointId = $pointId;
        $this->userLoginId = $userLoginId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
        $point = Point::with('user', 'journal')->find($this->pointId);
        $backgroundPath = storage_path('app/public/' . $point->journal->certificate);
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($point->journal->url));
        $tanggal = $point->created_at; 
        $bulan = $tanggal->format('F');
        $tahun = $tanggal->format('Y');
        
        $userLogin = $this->userLoginId ? User::find($this->userLoginId) : null;
        $data = [
            'email' => $point->user->email,
            'name' => $point->user->name,
            'user' => $point->user->name,
            'judul' => $point->Judul_Artikel,
            'journal' => $point->journal->title,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'qrcode' => $qrcode,
        ];

        $pdfOutput = FacadePdf::loadView('certificate.reviewing', compact('data', 'backgroundPath'))->output();
        $filename = 'Certificate of Contribution.pdf';

         // Buat instance mailable dengan data saja
            $mailable = new pointMailJob($data);
            
            // Tambahkan lampiran pada instance mailable
            $mailable->attachData($pdfOutput, $filename, ['mime' => 'application/pdf']);
           
            // Kirim email menggunakan instance mailable yang sudah lengkap
            Mail::to($data['email'])->send($mailable);

            // Log untuk debugging
            Log::info('Email berhasil dikirim ke: ' . $data['email']);
            
            if ($userLogin) {
                Notification::make()
                    ->title('Email Sertifikat Berhasil Dikirim')
                    ->body('Email berhasil dikirim ke ' . $data['email'])
                    ->success()
                    ->sendToDatabase($userLogin);
            }

        }

        catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            // Log error untuk debugging
            $email = isset($data) && isset($data['email']) ? $data['email'] : 'unknown';
            Log::error('Gagal mengirim email ke: ' . $email . '. Error: ' . $e->getMessage());
            
            $userLogin = $this->userLoginId ? User::find($this->userLoginId) : null;
            if ($userLogin) {
                Notification::make()
                    ->title('Gagal Mengirim Email')
                    ->body('Error mengirim email sertifikat: ' . $e->getMessage())
                    ->danger()
                    ->sendToDatabase($userLogin);
            }
        }

    }
}
