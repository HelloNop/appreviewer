<?php

namespace App\Http\Controllers;

use App\Models\JournalUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCertificatePositionMail;
use Filament\Notifications\Notification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class SendMailController extends Controller
{
    public function sendMailCertificatePosition($id) {
        $journaluser = JournalUser::find($id);
        $backgroundPath = storage_path('app/public/' . $journaluser->journal->certificate);
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($journaluser->journal->url));
        $data = [
            'user' => mb_convert_encoding($journaluser->user->name, 'UTF-8', 'UTF-8'),
            'backgroundPath' => $backgroundPath,
            'journal' => mb_convert_encoding($journaluser->journal->title, 'UTF-8', 'UTF-8'),
            'position' => mb_convert_encoding($journaluser->position, 'UTF-8', 'UTF-8'),
            'qrcode' => $qrcode,
        ];

        $fileName = 'Certificate_of_' . $journaluser->position . '_' . $journaluser->user->name . '.pdf';

        $pdf = FacadePdf::loadView('certificate.position-certificate', $data);
        $recipient = Auth::user();
        
        try {

            Mail::to($journaluser->user->email)->send(new SendCertificatePositionMail($data, $pdf, $fileName));
            
            Notification::make()
                ->title('Email Berhasil Dikirim')
                ->body('Email berhasil dikirim ke ' . $journaluser->user->email)
                ->success()
                ->send()
                ->sendToDatabase($recipient);

            return back();

        } catch (\Exception $e) {
            // Notifikasi error
           
            Notification::make()
                ->title('Gagal Mengirim Email')
                ->body('Terjadi kesalahan saat mengirim email: ' . $e->getMessage())
                ->danger()
                ->send()
                ->sendToDatabase($recipient);
                
            return back();
        }
    }
}
