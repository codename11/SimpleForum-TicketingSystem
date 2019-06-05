<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'body',
        'status'
    ];

    public function commentPost(){
        return $this->belongsTo("App\Post","post_id");
    }

    public function commentAuthor(){
        return $this->belongsTo("App\User","commenter_id");
    }

    public function replies() {
        return $this->hasMany('App\Comment', 'parent_id');
    }
}
