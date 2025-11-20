<?php

namespace App\Filament\Resources\FocusAndScopes;

use App\Filament\Resources\FocusAndScopes\Pages\CreateFocusAndScope;
use App\Filament\Resources\FocusAndScopes\Pages\EditFocusAndScope;
use App\Filament\Resources\FocusAndScopes\Pages\ListFocusAndScopes;
use App\Filament\Resources\FocusAndScopes\Schemas\FocusAndScopeForm;
use App\Filament\Resources\FocusAndScopes\Tables\FocusAndScopesTable;
use App\Models\FocusAndScope;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;       
use Illuminate\Contracts\Support\Htmlable;

class FocusAndScopeResource extends Resource
{

    protected static ?string $model = FocusAndScope::class;

    protected static string | UnitEnum | null $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 7;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $recordTitleAttribute = 'Focus And Scope';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function form(Schema $schema): Schema
    {
        return FocusAndScopeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FocusAndScopesTable::configure($table);
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
            'index' => ListFocusAndScopes::route('/'),
            'create' => CreateFocusAndScope::route('/create'),
            'edit' => EditFocusAndScope::route('/{record}/edit'),
        ];
    }
}
