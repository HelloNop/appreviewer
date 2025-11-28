<?php

namespace App\Filament\Resources\Publishers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class PublisherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('brand_name')
                    ->required(),
                TextInput::make('director')
                    ->required(),
                FileUpload::make('banner')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('banners')
                    ->visibility('public'),
                FileUpload::make('signature')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('signatures')
                    ->visibility('public'),

            ]);
    }
}
