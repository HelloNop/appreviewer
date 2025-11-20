<?php

namespace App\Filament\Resources\JournalUsers;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\JournalUser;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JournalUsers\Pages\ListJournalUsers;
use App\Filament\Resources\JournalUsers\Schemas\JournalUserForm;
use App\Filament\Resources\JournalUsers\Tables\JournalUsersTable;

class JournalUserResource extends Resource
{
    protected static ?bool $shouldSplitGlobalSearchTerms = false;
    protected static ?string $model = JournalUser::class;

    protected static string | UnitEnum | null $navigationGroup = 'Main Menu';
    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationLabel = 'Certificate and SK';

    public static function form(Schema $schema): Schema
    {
        return JournalUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JournalUsersTable::configure($table)
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
            'index' => ListJournalUsers::route('/'),
        ];
    }
}
