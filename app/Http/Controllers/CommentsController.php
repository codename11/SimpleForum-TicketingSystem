<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Auth;
use DB;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $post_id = $id;
        return view("comments.create")->with("post_id",$post_id);
        //return $post_id;
        //return view("comments.index")->with("post_id",$post_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            "body" => "required"
            
        ]);

        $data = array(
            "body" => $request->input("body"),
            "post_id" => intval($id),
            "commenter_id" => Auth::user()->id,
            "imParent_id" => $request->input("comment_id")
        );
        //dd($data);
        $comment = new Comment;
        $comment->body = $data["body"];
        $comment->post_id = $data["post_id"];
        $comment->commenter_id = $data["commenter_id"];
        $comment->parent_id = $data["imParent_id"];
        
        $comment->save();

        $post = Post::find($id);
        $comments = $post->comments;
        //return redirect("/posts/{{$id}}")->with("success", "Post Created")->with('comments', $comments);
        //return view("posts.show")->with(compact('post', 'comments'));
        //with(['replies' => function($comments){ $comments->orderBy('parent_id') } ])
        return back()->with('comments', $comments);
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

    public function softDelete(Request $request, $id, $comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->status = 0;
        $comment->save();
        return back();
    }

    public function softUnDelete(Request $request, $id, $comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->status = 1;
        $comment->save();
        return back();
    }

    public function update(Request $request, $id, $comment_id)
    {
        $comment = Comment::find($request->input("comment_id"));
        
        $this->validate($request, [
            "body" => "required"
            
        ]);

        $data = array(
            "body" => $request->input("body"),
            "post_id" => intval($id),
            "commenter_id" => Auth::user()->id,
            "imParent_id" => $request->input("comment_id")
        );

        

        
        $comment->body = $request->input("body");
        
        $comment->save();

        $post = Post::find($id);
        $comments = $post->comments;
        
        return back()->with('comments', $comments);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $comment_id)
    {
        
    }
}
