<?php

namespace App\Filament\Resources\FocusAndScopes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FocusAndScopeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
