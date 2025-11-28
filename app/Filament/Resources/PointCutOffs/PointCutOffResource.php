<?php

namespace App\Filament\Resources\PointCutOffs;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\PointCutOff;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PointCutOffs\Pages\ListPointCutOffs;
use App\Filament\Resources\PointCutOffs\Schemas\PointCutOffForm;
use App\Filament\Resources\PointCutOffs\Tables\PointCutOffsTable;
use App\Filament\Resources\PointCutOffs\Schemas\PointCutOffInfolist;

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
        return PointCutOffsTable::configure($table)
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
                if (
                    $user->roles->contains('name', 'Reviewer') ||
                    $user->roles->contains('name', 'Editor')
                ) {
                    $query->where('user_id', $user->id);
                }
            });
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
        ];
    }
}
