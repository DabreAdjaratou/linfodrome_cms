<?php

namespace App\Policies\Article;

use App\Models\User\User;
use App\Models\Article\Category;
use Illuminate\Auth\Access\HandlesAuthorization;


class CategoryPolicy
{
  use HandlesAuthorization;


    public function before($user)
    {
     return  User::isAdmin($user->id);
    }
    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Category  $category
     * @return mixed
     */
    public function view(User $user, Category $category)
    {
        if(User::getPermissions($user->id,'App\Models\Article\Category','view')){
       return true;
    }
    return false;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    if(User::getPermissions($user->id,'App\Models\Article\Category','create')){
       return true;
    }
    return false;
 //         
}

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Category  $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        if(User::getPermissions($user->id,'App\Models\Article\Category','update')){
       return true;
    }
    return false;
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        if(User::getPermissions($user->id,'App\Models\Article\Category','category')){
       return true;
    }
    return false;
    }

    /**
     * Determine whether the user can restore the category.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Category  $category
     * @return mixed
     */
    public function restore(User $user, Category $category)
    {
        if(User::getPermissions($user->id,'App\Models\Article\Category','restore')){
       return true;
    }
    return false;
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Article\Category  $category
     * @return mixed
     */
    public function forceDelete(User $user, Category $category)
    {
        if(User::getPermissions($user->id,'App\Models\Article\Category','destroy')){
       return true;
    }
    return false;
    }
}
