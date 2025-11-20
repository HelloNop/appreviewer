<?php

namespace App\Filament\Resources\Profreaders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProfreadersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
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
                SelectFilter::make('Journal')
                    ->relationship('journal', 'title')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->button()
                    ->color('secondary')
                    ->modalHeading('Edit Point')
                    ->modalSubmitActionLabel('Save')
                    ->modalCancelActionLabel('Cancel'),
            ])
            ->toolbarActions([

            ]);
    }
}
