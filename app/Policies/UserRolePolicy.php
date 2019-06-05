<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function isAdmin(User $user)
    {//dd($user);
        
        return $user->role_id===1;
        
    }

    public function isModerator(User $user)
    {//dd($user);
        
        return $user->role_id===2;
        
    }

    public function isUser(User $user)
    {//dd($user);
        
        return $user->role_id===3;
        
    }

    public function isPeon(User $user)
    {//dd($user);
        
        return $user->role_id===4;
        
    }
}
