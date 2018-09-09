<?php

namespace App\Policies\Article;

use App\Models\User\User;
use App\Models\Article\Revision;
use Illuminate\Auth\Access\HandlesAuthorization;

class RevisionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the revision.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Revision  $revision
     * @return mixed
     */
    public function view(User $user, Revision $revision)
    {
        //
    }

    /**
     * Determine whether the user can create revisions.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the revision.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Revision  $revision
     * @return mixed
     */
    public function update(User $user, Revision $revision)
    {
        //
    }

    /**
     * Determine whether the user can delete the revision.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Revision  $revision
     * @return mixed
     */
    public function delete(User $user, Revision $revision)
    {
        //
    }

    /**
     * Determine whether the user can restore the revision.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Revision  $revision
     * @return mixed
     */
    public function restore(User $user, Revision $revision)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the revision.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Revision  $revision
     * @return mixed
     */
    public function forceDelete(User $user, Revision $revision)
    {
        //
    }
}
