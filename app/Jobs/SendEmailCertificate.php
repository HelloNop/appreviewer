<?php

namespace App\Jobs;

use App\Mail\CertificateMail;
use App\Mail\ContributionMail;
use App\Models\User;
use App\Mail\MailJob;
use App\Mail\pointMailJob;
use App\Models\JournalUser;
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

class SendEmailCertificate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $journalUserId;
    protected $userLoginId;

    /**
     * Create a new job instance.
     */
    public function __construct($journalUserId)
    {
        $this->journalUserId = $journalUserId;
        $this->userLoginId = Auth::id();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $record = JournalUser::with('user', 'journal.publisher')->find($this->journalUserId);
            $banner = storage_path('app/public/' . $record->journal->publisher->banner);
            $fullUrl = route('public-profile', ['user' => $record->user->uuid]);
            $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($fullUrl));
            $sk_number = $record->sk_number;
            $ttd = storage_path('app/public/' . $record->journal->publisher->signature);
            $backgroundPath = storage_path('app/public/' . $record->journal->certificate);

            $userLoginId = $this->userLoginId ? User::find($this->userLoginId) : null;

            $data = [
                'user' => $record->user->name,
                'user_email' => $record->user->email,
                'journal' => $record->journal->title,
                'position' => $record->position,
                'qrcode' => $qrcode,
                'banner' => $banner,
                'publisher' => $record->journal->publisher->name,
                'brand' => $record->journal->publisher->brand_name,
                'sk_number' => $sk_number,
                'author' => $record->user->name,
                'affiliation' => $record->user->affiliation,
                'signature' => $ttd,
                'directure' => $record->journal->publisher->director,
                'tanggal_sk' => $record->created_at->format('d F Y'),
                'backgroundPath' => $backgroundPath,

            ];

            $pdfCertificate = FacadePdf::loadView('certificate.position-certificate', $data)->output();
            $pdfSk = FacadePdf::loadView('certificate.sk', $data)->output();

            $skName = 'SK -  ' . $record->position . '.pdf';
            $certificateName = 'Certificate_of_' . $record->position . '_' . $record->user->name . '.pdf';

            $certificate_sk =  new CertificateMail($data);
            $certificate_sk->attachData($pdfCertificate, $certificateName);
            $certificate_sk->attachData($pdfSk, $skName);

            Mail::to($data['user_email'])->send($certificate_sk);

            if ($userLoginId) {
                Notification::make()
                    ->title('Email Sertifikat Berhasil Dikirim')
                    ->body('Email berhasil dikirim ke ' . $data['user_email'])
                    ->success()
                    ->sendToDatabase($userLoginId);
            }


        } catch (\Exception $e) {
            Log::error("Failed to send certificate email to user ID: {$this->journalUserId}. Error: " . $e->getMessage());

            $userLoginId = $this->userLoginId ? User::find($this->userLoginId) : null;
            if ($userLoginId) {
                Notification::make()
                    ->title('Gagal Mengirim Email')
                    ->body('Error mengirim email sertifikat: ' . $e->getMessage())
                    ->danger()
                    ->sendToDatabase($userLoginId);
            }
        }
    }
}
