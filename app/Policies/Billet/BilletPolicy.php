<?php

namespace App\Policies\Billet;

use App\Models\User\User;
use App\Billet\Billet;
use Illuminate\Auth\Access\HandlesAuthorization;

class BilletPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the billet.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Billet\Billet  $billet
     * @return mixed
     */
    public function view(User $user, Billet $billet)
    {
        //
    }

    /**
     * Determine whether the user can create billets.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the billet.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Billet\Billet  $billet
     * @return mixed
     */
    public function update(User $user, Billet $billet)
    {
        //
    }

    /**
     * Determine whether the user can delete the billet.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Billet\Billet  $billet
     * @return mixed
     */
    public function delete(User $user, Billet $billet)
    {
        //
    }

    /**
     * Determine whether the user can restore the billet.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Billet\Billet  $billet
     * @return mixed
     */
    public function restore(User $user, Billet $billet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the billet.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Billet\Billet  $billet
     * @return mixed
     */
    public function forceDelete(User $user, Billet $billet)
    {
        //
    }
}
