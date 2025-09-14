<?php

namespace App\Filament\Resources\JournalUsers\Pages;

use Filament\Facades\Filament;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\JournalUsers\JournalUserResource;

class ListJournalUsers extends ListRecords
{
    protected static string $resource = JournalUserResource::class;
    public function getHeading(): string
    {
        $user = Filament::auth()->user(); // atau auth()->user()
        $roles = $user->roles->pluck('name')->toArray();

        if (in_array('Editor', $roles) || in_array('Reviewer', $roles)) {
            return 'Certificate';
        }

        return 'Certificate Editor and Reviewer';
    }

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
