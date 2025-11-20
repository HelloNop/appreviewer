<?php

namespace App\Jobs;

use App\Mail\ContributionMail;
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

class SendEmailContributionJob implements ShouldQueue
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
        $fullUrl = route('public-profile', ['user' => $point->user->uuid]);
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($fullUrl));
        $tanggal = $point->created_at; 
        $bulan = $tanggal->format('F');
        $tahun = $tanggal->format('Y');
        
        $userLogin = $this->userLoginId ? User::find($this->userLoginId) : null;
        $data = [
            'email' => $point->user->email,
            'name' => $point->user->name,
            'judul' => $point->Judul_Artikel,
            'journal' => $point->journal->title,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'qrcode' => $qrcode,
            'app_url' => config('app.url'),
            'login_url' => config('app.url') . '/admin/login',
        ];

        $pdfOutput = FacadePdf::loadView('certificate.reviewing', compact('data', 'backgroundPath'))->output();
        $filename = 'Certificate of Contribution.pdf';

            $mailable = new ContributionMail($data);
            $mailable->attachData($pdfOutput, $filename, ['mime' => 'application/pdf']);
           
            Mail::to($data['email'])->send($mailable);
            
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