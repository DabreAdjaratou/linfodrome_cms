<?php

namespace App\Policies\Article;

use App\Models\User\User;
use App\Models\Article\Archive;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArchivePolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the archive.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Archive  $archive
     * @return mixed
     */
    public function view(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can create archives.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
       
    }

    /**
     * Determine whether the user can update the archive.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Archive  $archive
     * @return mixed
     */
    public function update(User $user, Archive $archive)
    {
       
    }

    /**
     * Determine whether the user can delete the archive.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Archive  $archive
     * @return mixed
     */
    public function delete(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can restore the archive.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Archive  $archive
     * @return mixed
     */
    public function restore(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the archive.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Archive  $archive
     * @return mixed
     */
    public function forceDelete(User $user, Archive $archive)
    {
        //
    }
}
