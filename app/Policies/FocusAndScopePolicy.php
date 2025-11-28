<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FocusAndScope;
use Illuminate\Auth\Access\HandlesAuthorization;

class FocusAndScopePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FocusAndScope');
    }

    public function view(AuthUser $authUser, FocusAndScope $focusAndScope): bool
    {
        return $authUser->can('View:FocusAndScope');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FocusAndScope');
    }

    public function update(AuthUser $authUser, FocusAndScope $focusAndScope): bool
    {
        return $authUser->can('Update:FocusAndScope');
    }

    public function delete(AuthUser $authUser, FocusAndScope $focusAndScope): bool
    {
        return $authUser->can('Delete:FocusAndScope');
    }

    public function restore(AuthUser $authUser, FocusAndScope $focusAndScope): bool
    {
        return $authUser->can('Restore:FocusAndScope');
    }

    public function forceDelete(AuthUser $authUser, FocusAndScope $focusAndScope): bool
    {
        return $authUser->can('ForceDelete:FocusAndScope');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FocusAndScope');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FocusAndScope');
    }

    public function replicate(AuthUser $authUser, FocusAndScope $focusAndScope): bool
    {
        return $authUser->can('Replicate:FocusAndScope');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FocusAndScope');
    }

    public function action(AuthUser $authUser): bool
    {
        return $authUser->can('Action:FocusAndScope');
    }

}