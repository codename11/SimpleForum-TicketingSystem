<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user)
    {
        return ($user->isAdmin() || $user->isModerator() || $user->isUser()) && $user->status==1;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (($user->isAdmin() || $user->isModerator() || $user->isUser()) && $user->status==1);
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user)
    {
        return (($user->isAdmin() || $user->isModerator()) && $user->status==1);
    }

    public function checkIfAuthorized(User $user, Post $post)
    {
        //if(auth()->user()->id!==$post->user_id){
        /*dump($user->id." ".gettype($user->id));
        dump($post->user_id." ".gettype($post->user_id));
        dump($user->id===$post->user_id);*/
        
        return (($user->isAdmin() || $user->isModerator()) && $user->status==1);
        /*if($user->id!==$post->user_id){
            return redirect("/posts")->with("error", "Unauthorized page");
        }*/
        
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user)
    {
        return (($user->isAdmin() || $user->isModerator()) && $user->status==1);
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
