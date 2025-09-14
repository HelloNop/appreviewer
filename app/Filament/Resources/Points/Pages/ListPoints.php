<?php

namespace App\Filament\Resources\Points\Pages;

use App\Jobs\sendReviewerEmailJob;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Points\PointResource;
use Filament\Notifications\Notification;

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
                    SendReviewerEmailJob::dispatch($record->id, Auth::id());
                    Notification::make()
                        ->title('Sending Certificate Contribution')
                        ->body('Scheduling sending certificate contribution to ' . $record->user->email . ' Successfully')
                        ->success()
                        ->send();
                    Notification::make()
                        ->title('Point Reward')
                        ->body('Thank you for your contribution, you have received a point reward')
                        ->success()
                        ->sendToDatabase($record->user);
                }),
        ];
    }
}
