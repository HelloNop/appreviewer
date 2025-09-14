<?php

namespace App\Filament\Resources\JournalUsers;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\JournalUser;
use Filament\Schemas\Schema;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JournalUsers\Pages\EditJournalUser;
use App\Filament\Resources\JournalUsers\Pages\ListJournalUsers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Resources\JournalUsers\Pages\CreateJournalUser;
use App\Filament\Resources\JournalUsers\Schemas\JournalUserForm;
use App\Filament\Resources\JournalUsers\Tables\JournalUsersTable;

class JournalUserResource extends Resource
{
    protected static ?bool $shouldSplitGlobalSearchTerms = false;
    protected static ?string $model = JournalUser::class;

    protected static string | UnitEnum | null $navigationGroup = 'Main Menu';
    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    public static function getNavigationLabel(): string
    {
        $user = Filament::auth()->user(); // atau auth()->user()
        
        $roles = $user->roles->pluck('name')->toArray();

        if (in_array('Editor', $roles) || in_array('Reviewer', $roles)) {
            return 'My Certificate';
        }

        return 'Certificate'; // default untuk role lain
    }

    public static function form(Schema $schema): Schema
    {
        return JournalUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JournalUsersTable::configure($table)
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
            'index' => ListJournalUsers::route('/'),
        ];
    }
}
