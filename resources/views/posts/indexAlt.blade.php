@extends("layouts.app")

@section("content")
    <h1>Posts</h1> 
    
    @if(count($posts)>0)

        <div class="container">
            @foreach ($posts as $post)
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img class="postCover postCoverIndex" src="/storage/cover_images/{{$post->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
        
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif

    @if(count($comments)>0)
        <ul class="list-group list-group-flush">
            @foreach ($comments as $comment)

                <a href="/posts/{{$comment->post_id}}" class="list-group-item list-group-item-action">
                    {!!$comment->body!!}<span class="badge badge-primary badge-pill">{{$comment->id}}</span>
                </a>

            @endforeach
        </ul>
    @endif

@endsection