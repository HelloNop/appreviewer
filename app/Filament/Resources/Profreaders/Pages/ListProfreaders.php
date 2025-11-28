<?php

namespace App\Filament\Resources\Profreaders\Pages;

use App\Filament\Exports\ProfreaderExporter;
use App\Filament\Resources\Profreaders\ProfreaderResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListProfreaders extends ListRecords
{
    protected static string $resource = ProfreaderResource::class;
    protected static ?string $title = 'Proofreader';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Point')
                ->createAnother(false)
                ->modalHeading('Create Point for ProofReader')
                ->modalSubmitActionLabel('Save')
                ->modalCancelActionLabel('Cancel')
                ->after(function ($record) {
                    Notification::make()
                        ->title('Point Reward')
                        ->body('Thank you for your contribution, you have received a point reward')
                        ->success()
                        ->sendToDatabase($record->user);
            }),

            ExportAction::make()
                ->authorize('action', ProfreaderResource::class)
                ->label('Export')
                ->exporter(ProfreaderExporter::class),

        ];
    }
}
