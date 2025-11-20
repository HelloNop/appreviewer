<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Profreader;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfreaderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Profreader');
    }

    public function view(AuthUser $authUser, Profreader $profreader): bool
    {
        return $authUser->can('View:Profreader');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Profreader');
    }

    public function update(AuthUser $authUser, Profreader $profreader): bool
    {
        return $authUser->can('Update:Profreader');
    }

    public function delete(AuthUser $authUser, Profreader $profreader): bool
    {
        return $authUser->can('Delete:Profreader');
    }

    public function restore(AuthUser $authUser, Profreader $profreader): bool
    {
        return $authUser->can('Restore:Profreader');
    }

    public function forceDelete(AuthUser $authUser, Profreader $profreader): bool
    {
        return $authUser->can('ForceDelete:Profreader');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Profreader');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Profreader');
    }

    public function replicate(AuthUser $authUser, Profreader $profreader): bool
    {
        return $authUser->can('Replicate:Profreader');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Profreader');
    }

    public function action(AuthUser $authUser): bool
    {
        return $authUser->can('Action:Profreader');
    }

}