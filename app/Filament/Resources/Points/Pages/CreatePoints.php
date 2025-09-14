<?php

namespace App\Filament\Resources\Journals\Pages;


use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Points\PointResource;

class CreatePoints extends CreateRecord
{
    protected static string $resource = PointResource::class;

}

