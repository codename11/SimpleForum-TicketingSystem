<form method="POST" class="replyForm DisplayNone" action="/posts/{{$post->id}}/comments" id="reply{{ $comment->id }}">
                   
    <input id="{{ $comment->id }}" type="hidden" name="comment_id" value="{{ $comment->id }}" />
    <input type="hidden" name="post_id" value="{{ $comment->post_id }}" />
    
    @csrf
    <!-- https://laravel.com/docs/5.7/validation#available-validation-rules -->
    
    <div class="form-group animated {{$errBody}}">
        <textarea class="form-control" name="body" placeholder="Post body" required value=""></textarea>
    </div>

    <div>
        <button type="submit" class="btn btn-outline-success btn-sm">Post comment</button>
    </div>
    
</form>