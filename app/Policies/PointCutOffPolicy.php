<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PointCutOff;
use Illuminate\Auth\Access\HandlesAuthorization;

class PointCutOffPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PointCutOff');
    }

    public function view(AuthUser $authUser, PointCutOff $pointCutOff): bool
    {
        return $authUser->can('View:PointCutOff');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PointCutOff');
    }

    public function update(AuthUser $authUser, PointCutOff $pointCutOff): bool
    {
        return $authUser->can('Update:PointCutOff');
    }

    public function delete(AuthUser $authUser, PointCutOff $pointCutOff): bool
    {
        return $authUser->can('Delete:PointCutOff');
    }

    public function restore(AuthUser $authUser, PointCutOff $pointCutOff): bool
    {
        return $authUser->can('Restore:PointCutOff');
    }

    public function forceDelete(AuthUser $authUser, PointCutOff $pointCutOff): bool
    {
        return $authUser->can('ForceDelete:PointCutOff');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PointCutOff');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PointCutOff');
    }

    public function replicate(AuthUser $authUser, PointCutOff $pointCutOff): bool
    {
        return $authUser->can('Replicate:PointCutOff');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PointCutOff');
    }

    public function action(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PointCutOff');
    }

}