<?php

namespace App\Filament\Resources\PointCutOffs;

use App\Filament\Resources\PointCutOffs\Pages\CreatePointCutOff;
use App\Filament\Resources\PointCutOffs\Pages\EditPointCutOff;
use App\Filament\Resources\PointCutOffs\Pages\ListPointCutOffs;
use App\Filament\Resources\PointCutOffs\Pages\ViewPointCutOff;
use App\Filament\Resources\PointCutOffs\Schemas\PointCutOffForm;
use App\Filament\Resources\PointCutOffs\Schemas\PointCutOffInfolist;
use App\Filament\Resources\PointCutOffs\Tables\PointCutOffsTable;
use App\Models\PointCutOff;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PointCutOffResource extends Resource
{
    protected static ?bool $shouldSplitGlobalSearchTerms = false;
    protected static ?string $model = PointCutOff::class;

    protected static ?string $navigationLabel = 'Cutoff History';

    protected static string | UnitEnum | null $navigationGroup = 'Main Menu';
    protected static ?int $navigationSort = 4;


    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';


    public static function form(Schema $schema): Schema
    {
        return PointCutOffForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PointCutOffInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PointCutOffsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPointCutOffs::route('/'),
            // 'view' => ViewPointCutOff::route('/{record}'),
        ];
    }
}
