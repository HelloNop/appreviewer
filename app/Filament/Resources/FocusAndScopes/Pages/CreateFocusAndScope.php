<?php

namespace App\Filament\Resources\FocusAndScopes\Pages;

use App\Filament\Resources\FocusAndScopes\FocusAndScopeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFocusAndScope extends CreateRecord
{
    protected static string $resource = FocusAndScopeResource::class;

        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
