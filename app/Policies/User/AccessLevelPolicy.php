<?php

namespace App\Policies\User;

use App\Models\User\User;
use App\User\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessLevelPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the access level.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\AccessLevel  $accessLevel
     * @return mixed
     */
    public function view(User $user, AccessLevel $accessLevel)
    {
        //
    }

    /**
     * Determine whether the user can create access levels.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the access level.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\AccessLevel  $accessLevel
     * @return mixed
     */
    public function update(User $user, AccessLevel $accessLevel)
    {
        //
    }

    /**
     * Determine whether the user can delete the access level.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\AccessLevel  $accessLevel
     * @return mixed
     */
    public function delete(User $user, AccessLevel $accessLevel)
    {
        //
    }

    /**
     * Determine whether the user can restore the access level.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\AccessLevel  $accessLevel
     * @return mixed
     */
    public function restore(User $user, AccessLevel $accessLevel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the access level.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\AccessLevel  $accessLevel
     * @return mixed
     */
    public function forceDelete(User $user, AccessLevel $accessLevel)
    {
        //
    }
}
