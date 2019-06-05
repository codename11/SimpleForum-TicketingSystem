<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\User;

class Post extends Model
{
    /*
    protected $table = "posts";
    public $primaryKey = "id";
    public $timestamps = true;
    */

    //Govori da se traze samo odredjena polja. Bez ovoga neko bi mogao i id-jem da manipulise.
    //Mass-assignment
    protected $fillable = [
        "title", "body"
    ];

    public function user(){
        return $this->belongsTo("App\User","user_id");
    }

    public function comments(){
        return $this->hasMany("App\Comment");
    }

    public function prev($post)
    {
        if($post->orderBy('id', 'ASC')->where('id', '>', $post->id)->first()){
            $prev = $post->orderBy('id', 'ASC')->where('id', '>', $post->id)->first()->id;
        }
        else{
            $prev = $post->min('id');
        }
        
        return $prev;
    } 

    public function next($post)
    {
        if($post->orderBy('id', 'DESC')->where('id', '<', $post->id)->first()){
            $next = $post->orderBy('id', 'DESC')->where('id', '<', $post->id)->first()->id;
        }
        else{
            $next = $post->max('id');
        }
        
        return $next;
    } 

}
