<?php

namespace App\Policies\User;

use App\Models\User\User;
use App\User\Resource;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the resource.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Resource  $resource
     * @return mixed
     */
    public function view(User $user, Resource $resource)
    {
        //
    }

    /**
     * Determine whether the user can create resources.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the resource.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Resource  $resource
     * @return mixed
     */
    public function update(User $user, Resource $resource)
    {
        //
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Resource  $resource
     * @return mixed
     */
    public function delete(User $user, Resource $resource)
    {
        //
    }

    /**
     * Determine whether the user can restore the resource.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Resource  $resource
     * @return mixed
     */
    public function restore(User $user, Resource $resource)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the resource.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Resource  $resource
     * @return mixed
     */
    public function forceDelete(User $user, Resource $resource)
    {
        //
    }
}
