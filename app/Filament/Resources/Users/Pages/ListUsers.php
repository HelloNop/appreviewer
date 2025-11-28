<?php

namespace App\Filament\Resources\Users\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Spatie\Permission\Models\Role;
use App\Filament\Imports\UserImporter;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Users\UserResource;


class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->modalWidth('xl'),
            ImportAction::make()
                ->importer(UserImporter::class)
                ->authorize('action', UserResource::class),
        ];
    }

    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('All')->badge($this->getModel()::count())];

        $roles = Role::orderBy('name', 'asc')
            ->get();

        foreach ($roles as $role) {
            $tabs[$role->name] = Tab::make($role->name)
                ->badge($this->getModel()::role($role->name)->count())
                ->modifyQueryUsing(function (Builder $query) use ($role) {
                    return $query->whereHas('roles', function (Builder $query) use ($role) {
                        $query->where('name', $role->name);
                    });
                });
        }

        $tabs['pending'] = Tab::make('Pending')
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('status', 'pending');
            })
            ->badge($this->getModel()::where('status', 'pending')->count())
            ->badgeColor('danger');

        return $tabs;
    }
}
