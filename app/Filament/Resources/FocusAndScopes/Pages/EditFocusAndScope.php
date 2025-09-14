<?php

namespace App\Filament\Resources\FocusAndScopes\Pages;

use App\Filament\Resources\FocusAndScopes\FocusAndScopeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFocusAndScope extends EditRecord
{
    protected static string $resource = FocusAndScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
