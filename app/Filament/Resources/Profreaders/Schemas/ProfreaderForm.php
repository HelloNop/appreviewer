<?php

namespace App\Filament\Resources\Profreaders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;

class ProfreaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Proofreader')
                    ->relationship('user', 'name', function ($query) {
                        $query->whereHas('roles', function ($q) {
                            $q->where('name', 'proofreader');
                        });
                    })
                    ->searchable()
                    ->preload()
                    ->disabled(fn ($record) => $record !== null)
                    ->required(),
                Select::make('journal_id')
                    ->label('Journal')
                    ->relationship('journal', 'title')
                    ->searchable()
                    ->preload()
                    ->disabled(fn ($record) => $record !== null)
                    ->required(),
                TextArea::make('Judul_Artikel')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
