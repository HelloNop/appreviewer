<?php

namespace App\Filament\Resources\PointCutOffs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PointCutOffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('reason'),
            ]);
    }
}
