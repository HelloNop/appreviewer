<?php

namespace App\Filament\Resources\PointCutOffs\Pages;

use App\Filament\Resources\PointCutOffs\PointCutOffResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPointCutOff extends ViewRecord
{
    protected static string $resource = PointCutOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
