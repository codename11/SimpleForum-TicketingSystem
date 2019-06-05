@extends("layouts.app")

@section("content")
    <?php 
        /*Pregleda zasebno za title i description da li ima gresaka. 
        Ukoliko ih ima, dodeljume im klasu(crveni border).*/
        $errBody = $errors->has('body') ? 'shake' : '';
    ?>
    <a href="/posts" class="btn btn-outline-info btn-sm">Go Back</a>
    <div style="float:right;">
        <a href="/posts/{{$prev}}" class="btn btn-outline-success"><i class="fas fa-arrow-left"></i></a>
        <a href="/posts/{{$next}}" class="btn btn-outline-info"><i class="fas fa-arrow-right"></i></a>
    </div>
    <h1>{{$post->title}}</h1> 
    <div class="postContainer">
        <img class="postCover" src="/storage/cover_images/{{$post->cover_image}}">
        
            <div>
            <!--Ovako prikazuje html kod.-->
            <!--{{$post->body}}-->
                {!!$post->body!!}
            </div>
            
            <small class="timestamp">Written on {{$post->created_at}}</small>
    </div>
    
    @if(!Auth::guest())
        @if(Auth::check() && Auth::user()->role_id<3 && Auth::user()->role_id>0)
            <hr>
            <a href="/posts/{{$post->id}}/edit" class="btn btn-outline-primary btn-sm">Edit</a>

            <form action="/posts/{{$post->id}}" method="post" class="float-right">
                @csrf
                {{method_field("DELETE")}}
                
                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                    <div class="modal-content">
                
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Are yoy sure you want to delete this post?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                
                        <!-- Modal body -->
                        <div class="modal-body">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </div>
                
                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                
                    </div>
                    </div>
                </div>

            </form>
            
            <button class="btn btn-outline-danger btn-sm float-right" data-toggle="modal" data-target="#myModal">Delete</button>
        @endif
    @endif
       
    @auth
    <hr>

    @if(Auth::check() && Auth::user()->role_id<3 && Auth::user()->role_id>0)
        <form method="POST" action="/posts/{{$post->id}}/comments">
            @csrf
            <!-- https://laravel.com/docs/5.7/validation#available-validation-rules -->
            
            <div class="form-group animated {{$errBody}}">
                <textarea id="ckeditor" class="form-control" name="body" placeholder="Post body" required value=""></textarea>
            </div>

            <div>
                <button type="submit" class="btn btn-outline-success btn-sm">Post comment</button>
            </div>
            
        </form>
    @endif

    <hr>
    @endauth
    <h6 style="border-bottom: 1px solid whitesmoke;">Comments <span class="badge" style="background-color: whitesmoke; border: 1px solid silver;vertical-align: top;">{{count($comments)}}</span></h6>
    <div class="container commContainer">
        
        <ul class="list-group" style="list-style-type:none">

            @if(count($comms) > 0)

                @for($i=0;$i<count($comms);$i++)

                    <li class="list-group-item py-2 commBody" parent_id="{{$comms[$i]->parent_id}}" id="{{$comms[$i]->id}}">

                        @if($comms[$i]->status!=0)

                            {{$comms[$i]->body}}

                        @else

                            <p style="color: whitesmoke;">"This comment has been removed ..."</p>

                        @endif

                        @if(Auth::check() && Auth::user()->role_id<3 && Auth::user()->role_id>0 && $comms[$i]->status!=0)

                            <br><span class="btn btn-outline-primary btn-sm" style="width: 40px;height: 20px;line-height: 5px;padding: 5px;" onclick="reply('reply{{ $comms[$i]->id }}')";>reply</span>
                            @include('inc.replyForm', array('par' => $comms[$i]))
                            <form action="/posts/{{$post->id}}/comments/{{$comms[$i]->id}}" method="POST" class="float-right">
                                @csrf
                                {{method_field("PATCH")}}
                                
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            
                            </form>
                          
                        @endif

                    </li>

                    <li class="horDiv"></li>

                    @if(count($replies) > 0)

                        @for($j=0;$j<count($replies);$j++)

                            @if($comms[$i]->id==$replies[$j]->parent_id)
                            
                                <li class="list-group-item py-2 commBody" parent_id="{{$replies[$j]->parent_id}}" id="{{$replies[$j]->id}}">

                                    @if($replies[$j]->status!=0)
                                    
                                        {{$replies[$j]->body}}

                                    @else

                                        <p style="color: whitesmoke;">"This reply has been removed ..."</p>

                                    @endif

                                    @if(Auth::check() && Auth::user()->role_id<3 && Auth::user()->role_id>0 && $replies[$j]->status!=0)

                                        <br><span class="btn btn-outline-primary btn-sm smaller" onclick="reply('reply{{ $replies[$j]->id }}')";>reply</span>
                                        @include('inc.replyForm', array('par' => $replies[$j]))
                                        <form action="/posts/{{$post->id}}/comments/{{$comms[$i]->id}}" method="POST" class="float-right">
                                            @csrf
                                            
                                            @method('patch')
                                            
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        
                                        </form>

                                    @endif

                                </li>
                                <li class="horDiv"></li>
                            @endif

                            @for($k=$j;$k<count($replies);$k++)

                                @if($replies[$k]->parent_id==$replies[$j]->id)
                                    <li class="list-group-item py-2 commBody" parent_id="{{$replies[$k]->parent_id}}" id="{{$replies[$k]->id}}">

                                        @if($replies[$k]->status!=0)
                                            {{$replies[$k]->body}}
                                        
                                        @else

                                            <p style="color: whitesmoke;">"This reply has been removed ..."</p>
    
                                        @endif

                                        @if(Auth::check() && Auth::user()->role_id<3 && Auth::user()->role_id>0 && $replies[$k]->status!=0)

                                            <br><span class="btn btn-outline-primary btn-sm smaller" onclick="reply('reply{{ $replies[$k]->id }}')";>reply</span>
                                            @include('inc.replyForm', array('par' => $replies[$k]))
                                            <form action="/posts/{{$post->id}}/comments/{{$comms[$i]->id}}" method="POST" class="float-right">
                                                @csrf
                                                @method('patch')
                                                
                                                <button type="submit" class="btn btn-outline-danger btn-sm smaller">Delete</button>
                                            
                                            </form>

                                        @endif

                                    </li>
                                    <li class="horDiv"></li>
                                @endif

                            @endfor

                        @endfor

                    @endif
                
                @endfor

            @endif
        </ul>

@endsection