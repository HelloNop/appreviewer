<?php

namespace App\Filament\Resources\Points\Pages;

use App\Filament\Exports\PointExporter;
use App\Jobs\sendReviewerEmailJob;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Points\PointResource;
use App\Jobs\SendEmailContributionJob;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Notification;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class ListPoints extends ListRecords
{
    protected static string $resource = PointResource::class;

    protected function getHeaderActions(): array
    { 
        return [

            CreateAction::make()
                ->createAnother(false)
                ->modalHeading('Create Point for Reviewer')
                ->modalSubmitActionLabel('Save')
                ->modalCancelActionLabel('Cancel')
                ->after(function ($record) {
                    SendEmailContributionJob::dispatch($record->id, Auth::id());
                    Notification::make()
                        ->title('Point Reward')
                        ->body('Thank you for your contribution, you have received a point reward')
                        ->success()
                        ->sendToDatabase($record->user);    
                
                }),

            ExportAction::make()
                ->authorize('action', PointResource::class)
                ->exporter(PointExporter::class),
        ];
    }
}
