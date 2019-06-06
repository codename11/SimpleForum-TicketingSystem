<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rola(){
        return $this->belongsTo("App\Roles", "id");
    }

    public function posts(){
        return $this->hasMany("App\Post");
    }

    public function comments(){
        return $this->hasMany("App\Comment");
    }
   
    public function isAdmin()
    {//dd($user);
        
        return $this->rola()->where('role', 'administrator')->exists();
        
    }

    public function isModerator(User $user)
    {//dd($user);
        
        return $this->rola()->where('role', 'moderator')->exists();
        
    }

    public function isUser(User $user)
    {//dd($user);
        
        return $this->rola()->where('role', 'user')->exists();
        
    }

    public function isPeon(User $user)
    {//dd($user);
        
        return $this->rola()->where('role', 'peon')->exists();
        
    }
    
}
