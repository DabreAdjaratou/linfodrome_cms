<?php

namespace App\Policies\Article;

use App\Models\User\User;
use App\Models\Article\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the article.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Article  $article
     * @return mixed
     */
    public function view(User $user, Article $article)
    {
        
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->require_reset === 0) {
            return true;
        }
        return false ;
    }

    /**
     * Determine whether the user can update the article.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can restore the article.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Article  $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the article.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Article  $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }
}
