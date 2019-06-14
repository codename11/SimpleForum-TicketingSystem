@extends("layouts.app")

@section("content")

<body class="w3-theme-l5">

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:100%;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3 p-1" style="font-size: 12px;">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container text-align: justify;">
            <h4 class="w3-center">My Profile</h4>
            <p class="w3-center"><img src="/storage/cover_images/{{$user->avatar}}" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
            <hr>
            <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Email: {{$user->email}}</p>
            <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> Username: {{$user->name}}</p>
            <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> Member since: {{$user->created_at->format('d/m/Y')}}</p>
            <p><i class="fas fa-dungeon w3-margin-right w3-text-theme"></i> Role:{{$user->rola->role}}</p>
            
        </div>
      </div>
      <br>
      
      <!-- Alert Box -->
      <div class="w3-container w3-display-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-theme-l3 w3-display-topright">
          <i class="fa fa-remove"></i>
        </span>
        <p><strong>Hey!</strong></p>
        <p>People are looking at your profile. Find out who.</p>
      </div>
    
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
    <div class="w3-col m7 p-1" style="margin-bottom: 50px;">
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <h6 class="w3-opacity">New Post</h6>
                <?php /*Pregleda zasebno za title i description 
                da li ima gresaka. Ukoliko ih ima, dodeljuje im klasu(crveni border).*/
                    $errTitle = $errors->has('title') ? 'border-danger' : '';
                    $errBody = $errors->has('body') ? 'border-danger' : '';
                ?>
                @auth
                  @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isModerator() || Auth::user()->isUser()) && Auth::user()->status!=0)
                    <form method="POST" action="/profile/{{$user->id}}" enctype="multipart/form-data"> 
                        @csrf
                        <input id="profile_id" name="profile_id" type="hidden" value="{{$user->id}}">
                        <!-- https://laravel.com/docs/5.7/validation#available-validation-rules -->
                        <div class="form-group">
                            <input class="w3-border w3-padding {{$errTitle}}" style="width: 100%;" type="text" name="title" placeholder="Post title" required value="{{old('title')}}">
                        </div>
                        <div class="form-group">
                            <textarea id="editable" rows="1" class="w3-border w3-padding {{$errBody}}" style="width: 100%;" name="body" placeholder="Post body" required value="{{old('body')}}"></textarea>
                        </div>
            
                        <div class="form-group">
                            <input type="file" name="cover_image" id="cover_image">
                        </div>

                        <div>
                            <button type="submit" class="w3-button w3-theme"><i class="fas fa-feather-alt"></i>  Post</button> 
                        </div>
                    </form>
                  @endif
                @endauth
            </div>
          </div>
        </div>
      </div>
      
      @if(count($posts) > 0)

        <div class="d-flex" style="margin: 10px 0px;padding-top: 20px;">
            <div class="mx-auto" style="line-height: 10px;">
                {{$posts->links("pagination::bootstrap-4")}}
            </div>
        </div>

        @foreach($posts as $post)

          <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
            <img src="/storage/cover_images/{{$post->user->avatar}}" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
            <span class="w3-right w3-opacity">{{$post->created_at->diffForHumans()}}</span>
            <h4>{{$post->user->name}}</h4><br>
            <hr class="w3-clear">
            <?php 
              if(strlen($post->body) > 400){
                $bod = substr($post->body,0,400);
              
            ?>
            <div style="background-color: whitesmoke; padding: 10px;border-radius: 5px; text-align: center;">{!!$bod!!}<a href='/posts/{{$post->id}}' class='noDec' style='color: #15aabf;font-size: 1em;text-align: center;'>...Read more</a></div><br>
            <?php
              }
              else{
            ?>
                <a href='/posts/{{$post->id}}' class='noDec' style='color: #15aabf;font-size: 1em;text-align: center;vertical-align: middle;'><i class='fas fa-angle-double-right'></i> Go to post</a>
                <div style="background-color: whitesmoke; padding: 10px;border-radius: 5px; text-align: justify;">{!!$post->body!!}</div><br>
            <?php
                
              }
            ?>

            <!--Comments for particular post-->
            <?php

            $comms = $post->comments()->where("parent_id", "=", 0)->with(["replies"])->get();
            $replies =  $post->comments()->where("parent_id", "!=", 0)->with(["replies"])->get();

            ?>
            <a href="#" style="float: left;color: gray;font-size: 0.7em">Likes <span class="badge">{{$post->likes}}</span></a>
            <a href="#" onclick="toggleForm('comment{{$post->id}}')" style="float: right;color: gray;font-size: 0.7em"> Comments <span class="badge">@if((count($comms)+count($replies)) > 0) {{count($comms)+count($replies)}} @endif</span></a>
            
            <hr>
            <div style="display:block;">
              <form method="POST" action="/posts/{{$post->id}}/{{auth()->user()->id}}" style="display:inline-block;">
                @csrf
                <div>
                  <button type="submit" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>  Like</button> 
                </div>
                
              </form>

              <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom" onclick="toggleForm('comment{{$post->id}}')" style="display:inline-block;"><i class="fa fa-comment"></i>  Comment</button>
            </div>
              <div  id="comment{{ $post->id }}" style="display: none;">
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

                <div class="container commContainer">
            
                  <ul class="list-group noListStyle">
          
                      @if(count($comms) > 0)
          
                          @for($i=0;$i<count($comms);$i++)
                          
                              <li class="list-group-item py-2 commBody" parent_id="{{$comms[$i]->parent_id}}" id="{{$comms[$i]->id}}">
                                      
                                  @if($comms[$i]->status!=0 && $comms[$i]->parent_id===0)
                                  
                                  <div><img src="/storage/cover_images/{{$comms[$i]->commentAuthor->avatar}}" class="authName">{{$comms[$i]->commentAuthor->name}}</div><br>
                                  <div class="bodyComm">{{$comms[$i]->body}}</div>
                                      
                                  @else
          
                                      <p class="removedComm">"This comment has been removed ..."</p>
                                      @include('inc.unDeleteForm', array('par' => $comms[$i]))
          
                                  @endif
          
                                  @if(Auth::check() && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator") && $comms[$i]->status!=0)
          
                                      <br><span class="btn btn-outline-primary btn-sm smaller" onclick="toggleForm('reply{{ $comms[$i]->id }}')";>reply</span>
                                      @include('inc.replyForm', array('par' => $comms[$i]))
                                      <span class="btn btn-outline-success btn-sm smaller" onclick="toggleForm('update{{ $comms[$i]->id }}')";>update</span>
                                      @include('inc.updateForm', array('par' => $comms[$i]))
                                      @include('inc.deleteForm', array('par' => $comms[$i]))
                                    
                                  @endif
          
                              </li>
          
                              <li class="horDiv"></li>
          
                              @if(count($replies) > 0)
          
                                  @for($j=$i;$j<count($replies);$j++)
          
                                      @if($comms[$i]->id==$replies[$j]->parent_id && $replies[$j]->parent_id!==0)
                                                  
                                          <li class="list-group-item py-2 commBody" parent_id="{{$replies[$j]->parent_id}}" id="{{$replies[$j]->id}}">
          
                                              @if($replies[$j]->status!=0)
                                                  <div><img src="/storage/cover_images/{{$replies[$j]->commentAuthor->avatar}}" class="authName">{{$replies[$j]->commentAuthor->name}}</div><br>
                                                  <div class="repBody">{{$replies[$j]->body}}</div>
          
                                              @else
          
                                                  <p class="removedComm">"This reply has been removed ..."</p>
                                                  @include('inc.unDeleteForm', array('par' => $replies[$j]))
          
                                              @endif
          
                                              @if(Auth::check() && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator") && $replies[$j]->status!=0)
          
                                                  <br><span class="btn btn-outline-primary btn-sm smaller" onclick="toggleForm('reply{{ $replies[$j]->id }}')";>reply</span>
                                                  @include('inc.replyForm', array('par' => $replies[$j]))
                                                  <span class="btn btn-outline-success btn-sm smaller" onclick="toggleForm('update{{ $replies[$j]->id }}')";>update</span>
                                                  @include('inc.updateForm', array('par' => $replies[$j]))
                                                  @include('inc.deleteForm', array('par' => $replies[$j]))
          
                                              @endif
          
                                          </li>
                                          <li class="horDiv"></li>
                                      @endif
                                          
                                      @for($k=$j;$k<count($replies);$k++)
          
                                          @if($replies[$k]->parent_id==$replies[$j]->id && $replies[$k]->parent_id!==0)
                                                  
                                              <li class="list-group-item py-2 commBody" parent_id="{{$replies[$k]->parent_id}}" id="{{$replies[$k]->id}}">
          
                                                  @if($replies[$k]->status!=0)
                                                      <div><img src="/storage/cover_images/{{$replies[$k]->commentAuthor->avatar}}" class="authName">{{$replies[$k]->commentAuthor->name}}</div><br>
                                                      <div class="repBody">{{$replies[$k]->body}}</div>
                                                  
                                                  @else
          
                                                      <p class="removedComm">"This reply has been removed ..."</p>
                                                      @include('inc.unDeleteForm', array('par' => $replies[$k]))
                                                  @endif
          
                                                  @if(Auth::check() && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator") && $replies[$k]->status!=0)
          
                                                      <br><span class="btn btn-outline-primary btn-sm smaller" onclick="toggleForm('reply{{ $replies[$k]->id }}')";>reply</span>
                                                      @include('inc.replyForm', array('par' => $replies[$k]))
                                                      <span class="btn btn-outline-success btn-sm smaller" onclick="toggleForm('update{{ $replies[$k]->id }}')";>update</span>
                                                      @include('inc.updateForm', array('par' => $replies[$k]))
                                                      @include('inc.deleteForm', array('par' => $replies[$k]))
          
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
              </div>
            </div>
          </div>

        @endforeach
        
        <div class="d-flex" style="margin: 10px 0px;padding-top: 20px;">
            <div class="mx-auto" style="line-height: 10px;">
                {{$posts->links("pagination::bootstrap-4")}}
            </div>
        </div>

      @endif
      
    <!-- End Middle Column -->
    </div>
    
    <!-- Right Column -->
    <div class="w3-col m2 p-1">
      <div class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
          <p>Upcoming Events:</p>
          <img src="/w3images/forest.jpg" alt="Forest" style="width:100%;">
          <p><strong>Holiday</strong></p>
          <p>Friday 15:00</p>
          <p><button class="w3-button w3-block w3-theme-l4">Info</button></p>
        </div>
      </div>
      <br>
      
      <div class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
          <p>Friend Request</p>
          <img src="/w3images/avatar6.png" alt="Avatar" style="width:50%"><br>
          <span>Jane Doe</span>
          <div class="w3-row w3-opacity">
            <div class="w3-half">
              <button class="w3-button w3-block w3-green w3-section" title="Accept"><i class="fa fa-check"></i></button>
            </div>
            <div class="w3-half">
              <button class="w3-button w3-block w3-red w3-section" title="Decline"><i class="fa fa-remove"></i></button>
            </div>
          </div>
        </div>
      </div>
      <br>
      
      <div class="w3-card w3-round w3-white w3-padding-16 w3-center">
        <p>ADS</p>
      </div>
      <br>
      
      <div class="w3-card w3-round w3-white w3-padding-32 w3-center">
        <p><i class="fa fa-bug w3-xxlarge"></i></p>
      </div>
      
    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<script>


</script>

@endsection