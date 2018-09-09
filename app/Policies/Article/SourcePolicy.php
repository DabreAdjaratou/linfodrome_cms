<?php

namespace App\Policies\Article;

use App\Models\User\User;
use App\Models\Article\Source;
use Illuminate\Auth\Access\HandlesAuthorization;

class SourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the source.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Source  $source
     * @return mixed
     */
    public function view(User $user, Source $source)
    {
        //
    }

    /**
     * Determine whether the user can create sources.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the source.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Source  $source
     * @return mixed
     */
    public function update(User $user, Source $source)
    {
        //
    }

    /**
     * Determine whether the user can delete the source.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Source  $source
     * @return mixed
     */
    public function delete(User $user, Source $source)
    {
        //
    }

    /**
     * Determine whether the user can restore the source.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Source  $source
     * @return mixed
     */
    public function restore(User $user, Source $source)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the source.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Source  $source
     * @return mixed
     */
    public function forceDelete(User $user, Source $source)
    {
        //
    }
}
