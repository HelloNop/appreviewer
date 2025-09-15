<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Deldius\UserField\UserColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\Column;
use Illuminate\Foundation\Auth\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use BaconQrCode\Renderer\RendererStyle\Fill;
use Illuminate\Database\Eloquent\Collection;

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
                    ->label('Point')
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
                        Textarea::make('reason')
                            ->label('Reason for Cutting Point')
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                            if ($record->point == 0) {
                                Notification::make()
                                    ->title('Error Cut, User Point is 0')
                                    ->danger()
                                    ->send();
                                    return;
                            }
                            // simpan data di tabel cut_point
                            $record->pointCutOffs()->create([
                                'total' => $record->point,
                                'reason' => $data['reason'],
                                'user_id' => $record->id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            // update point user
                            $record->update(['point' => 0]);
                            Notification::make()
                                ->title('Point successfully cut')
                                ->body('Point: ' . $record->point . ' Reason: ' . $data['reason'])
                                ->success()
                                ->send()
                                ->sendToDatabase($record);
                    })
            ])
            ->toolbarActions([
                    BulkAction::make('delete')
                        ->icon('heroicon-o-trash')
                        ->label('Delete')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete()),

                    BulkAction::make('active')
                        ->icon('heroicon-o-check-circle')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Aktifkan User')
                        ->modalDescription('Apakah Anda yakin ingin mengaktifkan user untuk semua pengguna yang dipilih?')
                        ->modalSubmitActionLabel('Aktifkan')
                        ->action(function (Collection $records) {
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
                        ->requiresConfirmation()
                        ->modalHeading('Non-Aktifkan User')
                        ->modalDescription('Apakah Anda yakin ingin menonaktifkan user untuk semua pengguna yang dipilih?')
                        ->modalSubmitActionLabel('Non-Aktifkan')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['status' => 'pending']);
                            }
                            Notification::make()
                                ->title('User successfully inactive')
                                ->success()
                                ->send();
                        })
                        
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->label('Inactive'),
            ]);
    }
}
