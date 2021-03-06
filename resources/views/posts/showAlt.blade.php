@extends("layouts.app")

@section("content")
    <a href="/posts" class="btn btn-primary">Go Back</a>
    <h1>{{$post->title}}</h1> 
        <img style="width: 100%;" src="/storage/cover_images/{{$post->cover_image}}">
    <div>
        <!--Ovako prikazuje html kod.-->
        <!--{{$post->body}}-->
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}</small>
    <a href="/posts/{{$post->id}}/comments/create" class="btn btn-primary">Reply</a>
    <hr>
    
    @if(!Auth::guest() && Auth::user()->id===$post->user_id)
        <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>

        {!!Form::open(["action" => ["PostsController@destroy", $post->id], "method" => "POST", "class" => "float-right"])!!}
            @csrf
            {{Form::hidden("_method", "DELETE")}}
            {{Form::submit("Delete", ["class" => "btn btn-danger"])}}
        {!!Form::close()!!}

        <form action="/posts/{{$post->id}}" method="post" class="float-right">
            @csrf
            {{method_field("DELETE")}}
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>

    @endif
    
@endsection