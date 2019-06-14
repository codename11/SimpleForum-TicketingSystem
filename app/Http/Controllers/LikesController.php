<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Post;
use App\Like;
use App\Http\Controllers\Controller;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addLikes(Request $request, $id){
        
        //dd((int)$request["user_id"]);
        if ($request->user_id && $request->post_id && $request->user_id == $id){

            $post = Post::find($request["post_id"]);
            
            $likeX = Like::where(["post_id" => (int)$request["post_id"], "liker_id" => (int)$request["user_id"]])->get();
            
            if(count($likeX) == 0){
                $like = new Like;
                $like->post_id = (int)$request["post_id"];
                $like->liker_id = (int)$request["user_id"];
                $like->save();
    
                if($post->likes == null){

                    $post->likes = 1;

                }
                else if($post->likes != null){

                    $post->likes += 1;
                    
                }
                $post->save();
  
            }

            $comments = $post->comments;

            $prev = $post->prev($post);
            $next = $post->next($post);

            $comms = $post->comments()->where("parent_id", "=", 0)->with(["replies"])->get();
            $replies =  $post->comments()->where("parent_id", "!=", 0)->with(["replies"])->get();

            return back()->with(compact("post", "prev", "next", "comms", "replies", "comments"));
           
        }

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
