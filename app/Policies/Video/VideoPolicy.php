<?php

namespace App\Policies\Video;

use App\Models\User\User;
use App\Video\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;
    
    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the video.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Video\Video  $video
     * @return mixed
     */
    public function view(User $user, Video $video)
    {
        //
    }

    /**
     * Determine whether the user can create videos.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the video.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Video\Video  $video
     * @return mixed
     */
    public function update(User $user, Video $video)
    {
        //
    }

    /**
     * Determine whether the user can delete the video.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Video\Video  $video
     * @return mixed
     */
    public function delete(User $user, Video $video)
    {
        //
    }

    /**
     * Determine whether the user can restore the video.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Video\Video  $video
     * @return mixed
     */
    public function restore(User $user, Video $video)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the video.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Video\Video  $video
     * @return mixed
     */
    public function forceDelete(User $user, Video $video)
    {
        //
    }
}
