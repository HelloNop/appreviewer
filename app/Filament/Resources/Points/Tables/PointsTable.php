<?php

namespace App\Filament\Resources\Points\Tables;


use Filament\Tables\Table;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Blade;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PointsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('journal.title')
                    ->numeric()
                    ->sortable()
                    ->wrap()
                    ->words(10, end: '....'),
                TextColumn::make('Judul_Artikel')
                    ->searchable()
                    ->wrap()
                    ->words(10, end: '....'),
                IconColumn::make('is_cutoff')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                EditAction::make()
                    ->button()
                    ->color('secondary')
                    ->modalHeading('Edit Point')
                    ->modalSubmitActionLabel('Save')
                    ->modalCancelActionLabel('Cancel'),
               
                    Action::make('Certificate')
                    ->button()
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->color('primary')
                    ->openUrlInNewTab()
                    ->action(function (Model $record) {
                            $backgroundPath = storage_path('app/public/' . $record->journal->certificate);
                            $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($record->journal->url));
                            $tanggal = $record->created_at; 
                            $bulan = $tanggal->format('F');
                            $tahun = $tanggal->format('Y');
                            $data = [
                                'user' => $record->user->name,
                                'journal' => $record->journal->title,
                                'judul' => $record->Judul_Artikel,
                                'background' => $backgroundPath,
                                'qrcode' => $qrcode,
                                'bulan' => $bulan,
                                'tahun' => $tahun,
                            ];

                            $html = Blade::render(view('certificate.reviewing', compact('data', 'backgroundPath'))->render());
                            $pdf = Pdf::loadHTML($html);
                        
                            return response()->streamDownload(fn() => print($pdf->output()), 'Certificate_Reviewing_' . $record->user->name . '.pdf');
                    })
                ])


            ->toolbarActions([
            ]);
    }
}
