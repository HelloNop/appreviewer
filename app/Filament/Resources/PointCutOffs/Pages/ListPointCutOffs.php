<?php

namespace App\Filament\Resources\PointCutOffs\Pages;

use App\Filament\Resources\PointCutOffs\PointCutOffResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPointCutOffs extends ListRecords
{
    protected static string $resource = PointCutOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
