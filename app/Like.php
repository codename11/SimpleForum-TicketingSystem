<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        "post_id", "liker_id"
    ];

    public function user(){
        return $this->belongsTo("App\User","liker_id");
    }

    public function comment(){
        return $this->hasMany("App\Comment", "post_id");
    }
    
}
