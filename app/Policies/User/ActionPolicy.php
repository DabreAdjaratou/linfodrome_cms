<?php

namespace App\Policies\User;

use App\Models\User\User;
use App\User\Action;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the action.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Action  $action
     * @return mixed
     */
    public function view(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can create actions.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the action.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Action  $action
     * @return mixed
     */
    public function update(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can delete the action.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Action  $action
     * @return mixed
     */
    public function delete(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can restore the action.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Action  $action
     * @return mixed
     */
    public function restore(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the action.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\User\Action  $action
     * @return mixed
     */
    public function forceDelete(User $user, Action $action)
    {
        //
    }
}
