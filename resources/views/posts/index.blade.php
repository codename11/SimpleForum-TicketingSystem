@extends("layouts.app")

@section("content")
       
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">

                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    @if(count($comments)>10)<span class="text-muted">Last <span class="badge badge-secondary badge-pill"> 10</span>  of {{count($comments)}} comments </span>@else <p style="font-family: Verdana, sans-serif;font-size: 15px;line-height: 1.5;">No comments found</p> @endif
                </h4>
                
                <ul class="list-group mb-3">
                    @foreach ($comments as $key=>$value)
                    @if($key<10)
                        <li class="list-group-item list-group-item-action d-flex justify-content-between lh-condensed commImg">
                            <div class="lastComments">
                                <h6 class="my-0"><a href="/posts/{{$value->post_id}}" class="noDec"><small class="text-muted">{!!$value->body!!}</small></a></h6> 
                            </div>
                        </li>
                    @endif
                    @endforeach
                </ul>

            </div>

          <div class="col-md-8 order-md-1">
            
            @if(count($posts)>0)

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
                    <hr class="hrStyle">
                @endforeach
                
                <div class="d-flex" style="margin: 10px 0px;padding-top: 20px;">
                    <div class="mx-auto" style="line-height: 10px;">
                        {{$posts->links("pagination::bootstrap-4")}}
                    </div>
                </div>
            @else
                <p>No posts found</p>
            @endif

          </div>
        </div>   
        <button onclick="ajax(this)" class="btn btn-info" id="ajax">Ajax</button>
@endsection