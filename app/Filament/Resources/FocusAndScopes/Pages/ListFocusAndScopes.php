<?php

namespace App\Filament\Resources\FocusAndScopes\Pages;

use App\Filament\Resources\FocusAndScopes\FocusAndScopeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFocusAndScopes extends ListRecords
{
    protected static string $resource = FocusAndScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


}
