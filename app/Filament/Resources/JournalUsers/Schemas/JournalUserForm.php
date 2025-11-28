<?php

namespace App\Filament\Resources\JournalUsers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class JournalUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select::make('user_id')
                //     ->relationship('user', 'name')
                //     ->required(),
                // Select::make('journal_id')
                //     ->relationship('journal', 'title')
                //     ->required(),
                // // Select::make('position')
                // //     ->options(['Reviewer' => 'Reviewer', 'Editor' => 'Editor'])
                // //     ->required(),
            ]);
    }
}
