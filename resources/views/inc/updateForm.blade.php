
<form method="POST" class="replyForm DisplayNone" action="/posts/{{$post->id}}/comments/{{$comms[$i]->id}}" id="update{{$par->id}}">
                    
    <input id="{{$par->id}}" type="hidden" name="comment_id" value="{{$par->id}}" />
    <input type="hidden" name="post_id" value="{{$par->post_id }}" />
    @csrf
    <!-- https://laravel.com/docs/5.7/validation#available-validation-rules -->
    
    <div class="form-group animated {{$errBody}}">
        <textarea class="form-control" name="body" placeholder="Post body" required value="{{$par->body}}">{{$par->body}}</textarea>
    </div>

    <div>
        <button type="submit" class="btn btn-outline-success btn-sm">Update</button>
    </div>
    
</form>