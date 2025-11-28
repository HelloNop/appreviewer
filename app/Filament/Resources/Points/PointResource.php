<?php

namespace App\Filament\Resources\Points;

use BackedEnum;
use App\Models\Point;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\Points\Pages\EditPoint;
use App\Filament\Resources\Points\Pages\ListPoints;
use App\Filament\Resources\Points\Pages\CreatePoint;
use App\Filament\Resources\Points\Schemas\PointForm;
use App\Filament\Resources\Points\Tables\PointsTable;
use ToneGabes\Filament\Icons\Enums\Phosphor;
use UnitEnum;

class PointResource extends Resource
{
    protected static ?string $model = Point::class;
    protected static ?bool $shouldSplitGlobalSearchTerms = false;

    protected static string | UnitEnum | null $navigationGroup = 'Main Menu';
    protected static ?int $navigationSort = 1;

    public static function getGloballySearchableAttributes(): array
    {
        return ['Judul_Artikel'];
    }

    protected static string|BackedEnum|null $navigationIcon = Phosphor::Wallet;
    
    protected static ?string $navigationLabel = 'Point Reviewer';

    protected static ?string $recordTitleAttribute = 'Point Reviewer';

    public static function form(Schema $schema): Schema
    {
        return PointForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PointsTable::configure($table)
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
                if ($user->hasAnyRole(['Team', 'super_admin', 'admin'])) {
                    return $query;
                }

                if ($user->hasAnyRole(['Reviewer', 'Editor', 'Proofreader'])) {
                   return $query->where('user_id', $user->id);
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
            'index' => ListPoints::route('/'),
        ];
    }


}
