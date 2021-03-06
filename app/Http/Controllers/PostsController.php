<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;
use App\Roles;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\PostCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ["except" => ["index", "show"]]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $this->authorize('view', Post::class);
        /*$usersWithRole = Roles::with('users')->where('role', 'administrator')->get();
        $admins = User::whereHas('rola', function($q){$q->whereIn('role', ['user']);})->get();
        dd($admins);*/

        //$posts = Post::all();
        //$posts = Post::orderBy("created_at","desc")->get();
        //$posts = Post::orderBy("created_at","desc")->take(1)->get();
        //$post = Post::where("title","Post Two")->get();
        //return $post;
        //$posts = DB::select("SELECT * FROM posts");
        
        /*if(auth()->user()){
            $posts = Post::where("user_id",auth()->user()->id)->orderBy("created_at","desc")->paginate(5);
        }
        else{
            $posts = Post::orderBy("created_at","desc")->paginate(5);
        }*/
        
        $posts = Post::orderBy("created_at","desc")->paginate(5);
        $comments = Comment::all();
        //dump($posts);
        
        return view("posts.index")->with(compact("posts", "comments", "response"));
    }

    public function ajax(Request $request)
    { 
        $var1 = $request->var1;
        $var2 = $request->var2;
        $elem = $request->elem;
        /*
        $var1 = $request->input('var1');
        $var2 = $request->input('var2');
        */
        $this->authorize('view', Post::class);
        
        $posts = Post::orderBy("created_at","desc")->paginate(5);
        $comments = Comment::all();
        //return $request;
        return response()->json(array("posts"=> $posts, "comments"=> $comments, "var1"=> $var1, "var2"=> $var2, "elem"=> $elem), 200);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        
        $this->authorize('create', Post::class);
        
        return view("posts.create");
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /* 
        $request->validate([
            "title" => "required",
            "body" => "required"
        ]); 
        */
        
        //dd($request["title"],$request["body"],$request["cover_image"]);
        $this->validate($request, [
            "title" => "required|min:4|max:12",
            "body" => "required",
            "cover_image" => "image|nullable"
        ]);
        //dd($request["title"],$request["body"],$request["cover_image"]);
        if($request->hasFile("cover_image")){
            $filenameWithExt = $request->file("cover_image")->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file("cover_image")->getClientOriginalExtension();
            $fileNameToStore = $filename."_".time().".".$extension;
            $path = $request->file("cover_image")->storeAs("public/cover_images", $fileNameToStore);
        }
        else{
            $fileNameToStore = "noimage.jpg";
        }
        
        $post = new Post;
        $post->title = $request->input("title");
        $post->body = $request->input("body");
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        
        Mail::to(auth()->user()->email)->send(

            new PostCreated($post)

        );

        if($request->has("profile_id")) {
            $user = User::find(auth()->user()->id);
            $posts = Post::all();

            return back()->with(compact("user", "posts"));
        }
        
        return redirect("/posts")->with("success", "Post Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //$roles = new Roles();
        //$user = new User();
        //dump($roles->find($id));
        //dump($user->find(2));
        //dump(auth()->user()->role()->get());
        /*This twos are gold!*/
        /*$currentUser =  auth()->user();
        if($currentUser){

            $currentUserRoleId = $currentUser->role_id;
            $currentUserRole = $currentUser->find($currentUserRoleId)->rola;
            $currentUserRoleName = $currentUserRole->role;
            $userRoleName = User::find(auth()->user()->role_id)->rola->role;
            dump($currentUserRoleName);
            dump($userRoleName);
            $trt= new User();
            dump(auth()->user()->rola()->get());

        }*/

        //dump(auth()->user()->find(auth()->user()->role_id)->role->role);
        /*Posle moze kao ona autorizacija da se stavi u polisu kao funkcija. .... */
        /*This twos are gold!*/

        $post = Post::find($id);  
        $this->authorize('checkIfAuthorized', $post);
        $comments = $post->comments;
        //dump($comments);
        

        $comms = $post->comments()->where("parent_id", "=", 0)->with(["replies"])->get();
        $replies =  $post->comments()->where("parent_id", "!=", 0)->with(["replies"])->get();
        //dd($replies);
        //$user = User::find($comments->commenter_id);
        
        //return($comments);
        /*$data = [
            "post" =>
        ];*/
        $prev = $post->prev($post);
        $next = $post->next($post);
        $jason = response()->json($comments);
        //return view("posts.show")->with(compact("jason"));
        return view("posts.show")->with(compact("post", "prev", "next", "comms", "replies", "comments", "jason"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = Post::find($id);
        $this->authorize('update', $post);
        /*if(\Gate::denies("checkIfAuthorized",$post)){
            abort(403);
        }*///Isto alternativa.
        /*Moze bez drugog parametra, valjda polisa(PostPolicy) 
        uporedjuje sa trenutno ulogovanim korisnikom.
        $this->authorize('ifAuthorized', auth()->user()->id, $post);*/
        
        return view("posts.edit")->with("post", $post);
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

        $post = Post::find($id);
        /*Moze bez drugog parametra, valjda polisa(PostPolicy) 
        uporedjuje sa trenutno ulogovanim korisnikom.
        $this->authorize('ifAuthorized', auth()->user()->id, $post);*/
        $this->authorize('checkIfAuthorized', $post);

        $this->validate($request, [
            "title" => "required",
            "body" => "required",
            "cover_image" => "image|nullable"
        ]);

        if($request->hasFile("cover_image")){
            $filenameWithExt = $request->file("cover_image")->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file("cover_image")->getClientOriginalExtension();
            $fileNameToStore = $filename."_".time().".".$extension;
            $path = $request->file("cover_image")->storeAs("public/cover_images", $fileNameToStore);
        }

        //$post = new Post;

        $post->title = $request->input("title");
        $post->body = $request->input("body");

        if($request->hasFile("cover_image")){
            $post->cover_image = $fileNameToStore;
        }

        $post->save();

        return redirect("/posts")->with("success", "Post Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Post::find($id);
        /*if(\Gate::allows("checkIfAuthorized",$post)){
            abort(403);
        }*/
        /*Moze bez drugog parametra, valjda polisa(PostPolicy) 
        uporedjuje sa trenutno ulogovanim korisnikom.*/
        //$this->authorize('checkIfAuthorized', auth()->user()->id, $post);
        $this->authorize('delete', Post::class);
        

        if($post->cover_image!="noimage.jpg"){
            Storage::delete("public/cover_images/".$post->cover_image);
        }

        $post->delete();
        return redirect("/posts")->with("success", "Post removed");
    }

}
