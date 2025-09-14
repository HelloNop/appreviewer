<?php

namespace App\Http\Controllers;

use App\Models\JournalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class EmailJobController extends Controller
{
    public function mailJob($id) {
        $journaluser = JournalUser::find($id);
        $recipient = Auth::user();

        // Kirim hanya data yang dibutuhkan, bukan objek PDF
        $data = [
            'recipient_id' => $recipient->id,
            'user_name' => $this->cleanUtf8($journaluser->user->name),
            'user_email' => $this->cleanUtf8($journaluser->user->email),
            'journal_title' => $this->cleanUtf8($journaluser->journal->title),
            'journal_certificate_path' => $this->cleanUtf8($journaluser->journal->certificate), // Cukup path-nya
            'position' => $this->cleanUtf8($journaluser->position),
            'journal_url' => $this->cleanUtf8($journaluser->journal->url),
        ];
        
        // Debug: Log data sebelum dispatch untuk memastikan tidak ada karakter invalid
        Log::info('Data before dispatch:', $data);
        
        // Validasi bahwa semua data dapat di-encode ke JSON
        $jsonTest = json_encode($data);
        if ($jsonTest === false) {
            Log::error('JSON encoding failed for data:', ['error' => json_last_error_msg(), 'data' => $data]);
            throw new \Exception('Data contains invalid characters that cannot be JSON encoded');
        }


    try {
        // Antrekan job baru dengan data yang dapat diserialisasikan
        // \App\Jobs\SendCertificateEmailJob::dispatch($data);
        \App\Jobs\SendCertificateEmailJob::dispatch($data);
        
        Notification::make()
            ->title('Email Scheduled')
            ->body('Email Will Be Sent To ' . $journaluser->user->email . ' In The Background.')
            ->success()
            ->sendToDatabase($recipient);

        

    } catch (\Exception $e) {
        Notification::make()
            ->title('Scheduling Email Failed')
            ->body('Error scheduling email: ' . $e->getMessage())
            ->danger()
            ->sendToDatabase($recipient);
            
        return back();
    }
    }
    
    /**
     * Clean UTF-8 string to prevent JSON encoding errors
     */
    private function cleanUtf8($string)
    {
        if (is_null($string)) {
            return null;
        }
        
        // Remove or replace invalid UTF-8 characters
        $clean = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        
        // Additional cleaning: remove non-printable characters except common whitespace
        $clean = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $clean);
        
        // Ensure it's valid JSON-encodable
        if (json_encode($clean) === false) {
            // If still problematic, use a more aggressive approach
            $clean = htmlspecialchars(strip_tags($clean), ENT_QUOTES, 'UTF-8');
        }
        
        return $clean;
    }
}
