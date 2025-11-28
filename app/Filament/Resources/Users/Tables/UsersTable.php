<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Foundation\Auth\User;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Point;
use App\Models\Profreader;
use Filament\Forms\Components\Select;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('point')
                    ->label('Rev Point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('point_proofreader')
                    ->label('Proof Point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
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
                ViewAction::make()
                    ->iconButton()
                    ->color('primary')
                    ->modalHeading('Detail Informasi User')
                    ->modalWidth('2xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->icon('heroicon-o-eye'),
                EditAction::make()
                    ->iconButton()
                    ->label('Edit')
                    ->color('secondary')
                    ->modalWidth('xl')
                    ->icon('heroicon-o-pencil'),
                Action::make('Cut')
                    ->authorize('action', User::class)
                    ->label('Cut Point')
                    ->button()
                    ->modalWidth('xl')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    
                    ->schema([
                        Select::make('type')
                            ->label('Type of Cutting Point')
                            ->options([
                                'reviewer' => 'Reviewer Point',
                                'proofreader' => 'Proofreader Point',
                            ])
                            ->required(),
                        Textarea::make('reason')
                            ->label('Reason for Cutting Point')
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        self::handleCut($record, $data['type'], $data['reason']);
                    })
            ])
            ->toolbarActions([
                    BulkAction::make('delete')
                        ->authorize('action', User::class)
                        ->icon('heroicon-o-trash')
                        ->label('Delete')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete()),
                    
                    BulkAction::make('active')
                        ->authorize('action', User::class)
                        ->icon('heroicon-o-check-circle')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Aktifkan User')
                        ->modalDescription('Apakah Anda yakin ingin mengaktifkan user untuk semua pengguna yang dipilih?')
                        ->modalSubmitActionLabel('Aktifkan')
                        ->action(function (\App\Models\User $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'active',
                                ]);
                            }
                            Notification::make()
                                    ->title('User successfully active')
                                    ->success()
                                    ->send();
                        })
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->label('Active'),


                    BulkAction::make('inactive')
                        ->authorize('action', User::class)
                        ->requiresConfirmation()
                        ->modalHeading('Non-Aktifkan User')
                        ->modalDescription('Apakah Anda yakin ingin menonaktifkan user untuk semua pengguna yang dipilih?')
                        ->modalSubmitActionLabel('Non-Aktifkan')
                        ->action(function (\App\Models\User $records) {
                            foreach ($records as $record) {
                                $record->update(['status' => 'pending']);
                            }
                            Notification::make()
                                ->title('User successfully inactive')
                                ->success()
                                ->send();
                        })
                        
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->label('Inactive'),

                    BulkAction::make('cut')
                        ->authorize('action', User::class)
                        ->label('Cut Point')
                        ->button()
                        ->modalWidth('xl')
                        ->color('danger')
                        ->icon('heroicon-o-x-circle')
                        ->schema([
                            Select::make('type')
                                ->label('Type of Cutting Point')
                                ->options([
                                    'reviewer' => 'Reviewer Point',
                                    'proofreader' => 'Proofreader Point',
                                ])
                                ->required(),
                            Textarea::make('reason')
                                ->label('Reason for Cutting Point')
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(fn($record) => self::handleCut($record, $data['type'], $data['reason']));
                        })
                        ->requiresConfirmation(),
            ]);
    }



    protected static function handleCut(User $record, string $type, string $reason)
    {
        $point = 0;

        switch ($type) {
            case 'proofreader':
                if ($record->point_proofreader == 0) {
                    Notification::make()
                        ->title('Error Cut, User Proofreader Point is 0')
                        ->danger()
                        ->send();
                    return false;
                }

                $point = $record->point_proofreader;

                // create point cut off
                $record->pointCutOffs()->create([
                    'total' => $point,
                    'reason' => $reason,
                    'type' => $type,
                    'user_id' => $record->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // update point user
                $record->update(['point_proofreader' => 0]);

                // update tabel profreaders
                Profreader::where('user_id', $record->id)->update([
                    'is_cutoff' => 1,
                    'cut_off_date' => now(),
                ]);

                break;

            case 'reviewer':
                if ($record->point == 0) {
                    Notification::make()
                        ->title('Error Cut, User Reviewer Point is 0')
                        ->danger()
                        ->send();
                    return false;
                }

                $point = $record->point;

                // create point cut off
                $record->pointCutOffs()->create([
                    'total' => $point,
                    'reason' => $reason,
                    'type' => $type,
                    'user_id' => $record->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // update point user
                $record->update(['point' => 0]);

                // update tabel points
                Point::where('user_id', $record->id)->update([
                    'is_cutoff' => 1,
                    'cut_off_date' => now(),
                ]);

                break;

            default:
                Notification::make()
                    ->title('Unknown Type')
                    ->warning()
                    ->send();
                return false;
        }

        // Notification berhasil
        Notification::make()
            ->title('Point successfully cut')
            ->body("Point: $point, Reason: $reason")
            ->success()
            ->send()
            ->sendToDatabase($record);

        return true;
    }

}
