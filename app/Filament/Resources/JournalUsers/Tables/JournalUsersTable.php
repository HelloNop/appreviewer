<?php

namespace App\Filament\Resources\JournalUsers\Tables;

use Filament\Tables\Table;
use App\Models\JournalUser;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\EmailJobController;

class JournalUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('journal.title')
                    ->searchable()
                    ->wrap(6),
                TextColumn::make('position')
                    ->badge(),
                IconColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-exclamation-triangle',
                        'accepted' => 'heroicon-o-check-circle',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('Download')
                    // ->url(fn ($record): string => route('certificate.download', $record->id))
                    ->button()
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->color('primary')
                    ->disabled(fn (Model $record): bool => $record->status != 'accepted')
                    ->action(function (Model $record) {

                            $backgroundPath = storage_path('app/public/' . $record->journal->certificate);
                            $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($record->journal->url));
                            $data = [
                                'user' => $record->user->name,
                                'journal' => $record->journal->title,
                                'position' => $record->position,
                                'qrcode' => $qrcode,
                                'backgroundPath' => $backgroundPath,
                            ];
                            $pdf = Pdf::loadView('certificate.position-certificate', $data);
                        return response()->streamDownload(fn() => print($pdf->output()), 'Certificate_of_' . $record->position . '_' . $record->user->name . '.pdf');
                    }),
            

                Action::make('Email')
                    ->button()
                    ->icon('heroicon-o-paper-airplane')
                    // ->visible(fn () => auth()->user()->hasRole('super_admin')) 
                    ->authorize('action', JournalUser::class)
                    ->color('secondary')
                    ->disabled(fn (Model $record): bool => $record->status != 'accepted')
                    ->action(function ($record) {
                        // (new SendMailController())->sendMailCertificatePosition($record->id);
                        (new EmailJobController())->mailJob($record->id);
                        Notification::make()
                             ->title('test record sweetalert')
                             ->body('Email akan dikirim ke ' . $record->user->email . ' di latar belakang.')
                             ->success()
                             ->send();
                    }),
                
                Action::make('active')
                    ->button()
                    ->label('Acc')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                     ->authorize('action', JournalUser::class)
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'accepted',
                        ]);

                        Notification::make()
                             ->title('Asign New Position')
                             ->body($record->user->name . ' berhasil diaktifkan sebagai ' . $record->position .' on ' . $record->journal->title)
                             ->success()
                             ->send()
                             ->sendToDatabase($record->user);
                    }),
            ])
            
            ->toolbarActions([
                    BulkAction::make('Send Email')
                     ->authorize('action', JournalUser::class)
                    ->icon('heroicon-o-paper-airplane')
                    ->color('secondary')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Email Sertifikat')
                    ->modalDescription('Apakah Anda yakin ingin mengirim email sertifikat ke semua pengguna yang dipilih?')
                    ->modalSubmitActionLabel('Kirim Email')
                    ->action(function ($records) {
                        $emailController = new EmailJobController();
                        $successCount = 0;
                        $errorCount = 0;
                        
                        foreach ($records as $record) {
                            try {
                                $emailController->mailJob($record->id);
                                $successCount++;
                            } catch (\Exception $e) {
                                $errorCount++;
                            }
                        }
                        
                        Notification::make()
                             ->title('Bulk Email Selesai')
                             ->body("Email berhasil dijadwalkan untuk {$successCount} pengguna." . 
                                    ($errorCount > 0 ? " {$errorCount} email gagal dijadwalkan." : ''))
                             ->success()
                             ->send();
                    }),
                    BulkAction::make('Active')
                         ->authorize('action', JournalUser::class)
                        ->icon('heroicon-o-check-circle')
                        ->button()
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Aktifkan Sertifikat')
                        ->modalDescription('Apakah Anda yakin ingin mengaktifkan sertifikat untuk semua pengguna yang dipilih?')
                        ->modalSubmitActionLabel('Aktifkan')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'accepted',
                                ]);
                            }

                            Notification::make()
                                ->title('Bulk Aktifkan Sertifikat Selesai')
                                ->success()
                                ->send();
                    }),
    
            ]);
    }
}
