<?php

namespace App\Filament\Resources\Profreaders;

use App\Filament\Resources\Profreaders\Pages\CreateProfreader;
use App\Filament\Resources\Profreaders\Pages\EditProfreader;
use App\Filament\Resources\Profreaders\Pages\ListProfreaders;
use App\Filament\Resources\Profreaders\Schemas\ProfreaderForm;
use App\Filament\Resources\Profreaders\Tables\ProfreadersTable;
use App\Models\Profreader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProfreaderResource extends Resource
{
    protected static ?string $model = Profreader::class;
    protected static ?bool $shouldSplitGlobalSearchTerms = false;
    protected static string | UnitEnum | null $navigationGroup = 'Main Menu';
    protected static ?int $navigationSort = 1;
    
    public static function getGloballySearchableAttributes(): array
    {
        return ['Judul_Artikel'];
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Proofreader Point';
    protected static ?string $navigationLabel = 'Point Proofreader';

    public static function form(Schema $schema): Schema
    {
        return ProfreaderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfreadersTable::configure($table);
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
            'index' => ListProfreaders::route('/'),
        ];
    }
}
