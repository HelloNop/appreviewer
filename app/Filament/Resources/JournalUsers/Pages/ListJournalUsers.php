<?php

namespace App\Filament\Resources\JournalUsers\Pages;

use Filament\Facades\Filament;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\JournalUsers\JournalUserResource;

class ListJournalUsers extends ListRecords
{
    protected static string $resource = JournalUserResource::class;
    protected static ?string $title = 'Certificate';

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
