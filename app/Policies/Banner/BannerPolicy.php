<?php

namespace App\Policies\Banner;

use App\Models\User\User;
use App\Banner\Banner;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the banner.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Banner\Banner  $banner
     * @return mixed
     */
    public function view(User $user, Banner $banner)
    {
        //
    }

    /**
     * Determine whether the user can create banners.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the banner.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Banner\Banner  $banner
     * @return mixed
     */
    public function update(User $user, Banner $banner)
    {
        //
    }

    /**
     * Determine whether the user can delete the banner.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Banner\Banner  $banner
     * @return mixed
     */
    public function delete(User $user, Banner $banner)
    {
        //
    }

    /**
     * Determine whether the user can restore the banner.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Banner\Banner  $banner
     * @return mixed
     */
    public function restore(User $user, Banner $banner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the banner.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Banner\Banner  $banner
     * @return mixed
     */
    public function forceDelete(User $user, Banner $banner)
    {
        //
    }
}
