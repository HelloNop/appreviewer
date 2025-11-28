<?php

namespace App\Filament\Resources\JournalUsers\Tables;

use App\Jobs\SendEmailCertificate;
use Filament\Tables\Table;
use App\Models\JournalUser;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class JournalUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('journal.singkatan')
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
                SelectFilter::make('Journal')
                    ->relationship('journal', 'singkatan')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ])

            ->recordActions([
                Action::make('Certificate')
                    ->button()
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->color('primary')
                    ->disabled(fn (Model $record): bool => $record->status != 'accepted')
                    ->action(function (Model $record) {
                            $backgroundPath = storage_path('app/public/' . $record->journal->certificate);
                            $fullUrl = route('public-profile', ['user' => $record->user->uuid]);
                            $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($fullUrl));
                            $sk_number = $record->sk_number;
                            $data = [
                                'user' => $record->user->name,
                                'journal' => $record->journal->title,
                                'position' => $record->position,
                                'qrcode' => $qrcode,
                                'backgroundPath' => $backgroundPath,
                                'sk_number' => $sk_number,
                            ];
                            $pdf = Pdf::loadView('certificate.position-certificate', $data);
                        return response()->streamDownload(fn() => print($pdf->output()), 'Certificate_of_' . $record->position . '_' . $record->user->name . '.pdf');
                    }),
                
                Action::make('Download SK')
                    ->label('Unduh SK')
                    ->button()
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->color('primary')
                    ->disabled(fn (Model $record): bool => $record->status != 'accepted')
                    ->action(function (Model $record) {
                            $banner = storage_path('app/public/' . $record->journal->publisher->banner);
                            $fullUrl = route('public-profile', ['user' => $record->user->uuid]);
                            $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($fullUrl));
                            $sk_number = $record->sk_number;
                            $ttd = storage_path('app/public/' . $record->journal->publisher->signature);

                            $data = [
                                'user' => $record->user->name,
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

                            ];
                            $pdf = Pdf::loadView('certificate.sk', $data);
                        
                            return response()->streamDownload(fn() => print($pdf->output()), 'SK' . '-' . $record->id . '-' . $record->journal->singkatan . '_' . $record->user->name . '.pdf');
                    }),
            
                Action::make('Email')
                    ->button()
                    ->icon('heroicon-o-paper-airplane')
                    ->authorize('action', JournalUser::class)
                    ->color('secondary')
                    ->disabled(fn (Model $record): bool => $record->status != 'accepted')
                    ->action(function (Model $record) {
                        SendEmailCertificate::dispatch($record->id);

                    Notification::make()
                        ->title('Email sedang diproses. Mohon tunggu (bisa sampai beberapa menit).')
                        ->warning()
                        ->send();
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
                            $count = 0;
                            $acceptedOnly = 0;
                            
                            foreach ($records as $record) {
                                if ($record->status == 'accepted') {
                                    SendEmailCertificate::dispatch($record->id);
                                    $count++;
                                } else {
                                    $acceptedOnly++;
                                }
                            }

                            if ($count > 0) {
                                Notification::make()
                                    ->title('Email Sedang Diproses')
                                    ->body("$count email sertifikat sedang diproses dan akan dikirim dalam beberapa saat." . 
                                           ($acceptedOnly > 0 ? " ($acceptedOnly pengguna dilewati karena belum accepted)" : ""))
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Tidak Ada Email yang Dikirim')
                                    ->body('Semua pengguna yang dipilih belum dalam status accepted.')
                                    ->warning()
                                    ->send();
                            }
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
