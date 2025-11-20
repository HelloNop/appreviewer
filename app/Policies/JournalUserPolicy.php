<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\JournalUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalUserPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:JournalUser');
    }

    public function view(AuthUser $authUser, JournalUser $journalUser): bool
    {
        return $authUser->can('View:JournalUser');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:JournalUser');
    }

    public function update(AuthUser $authUser, JournalUser $journalUser): bool
    {
        return $authUser->can('Update:JournalUser');
    }

    public function delete(AuthUser $authUser, JournalUser $journalUser): bool
    {
        return $authUser->can('Delete:JournalUser');
    }

    public function restore(AuthUser $authUser, JournalUser $journalUser): bool
    {
        return $authUser->can('Restore:JournalUser');
    }

    public function forceDelete(AuthUser $authUser, JournalUser $journalUser): bool
    {
        return $authUser->can('ForceDelete:JournalUser');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:JournalUser');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:JournalUser');
    }

    public function replicate(AuthUser $authUser, JournalUser $journalUser): bool
    {
        return $authUser->can('Replicate:JournalUser');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:JournalUser');
    }

    public function action(AuthUser $authUser): bool
    {
        return $authUser->can('Action:JournalUser');
    }


}