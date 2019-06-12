@extends("layouts.app")

@section("content")
    <h1>Edit Post</h1> 

    <form method="POST" action="/posts/{{$post->id}}">
        {{method_field("PUT")}}
        @csrf

        <div class="form-group">
            <label class="label" for="title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title" value="{{$post->title}}" required>
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea class="form-control" id="ckeditor" name="body" placeholder="Body" required>{{$post->body}}</textarea>
        </div>
        
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Are you sure you want to update this post?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <button type="submit" class="btn btn-outline-primary">Update Post</button>
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
        
            </div>
            </div>
        </div>
           
    </form>
    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 30px;">Update Post</button>
@endsection