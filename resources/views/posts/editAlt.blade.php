@extends("layouts.app")

@section("content")
    <h1>Edit Post</h1> 
    {{ Form::open(["action" => ["PostsController@update",$post->id], "method" => "post", "enctype" => "multipart/form-data"]) }}
        @csrf
        <div class="form-group">
            {{Form::label("title","Title")}}
            {{Form::text("title",$post->title,["class" => "form-control", "placeholder" => "Title"])}}
        </div>

        <div class="form-group">
            {{Form::label("body","Body")}}
            {{Form::textarea("body",$post->body,["class" => "form-control", "placeholder" => "Body text", "id" => "ckeditor"])}}
        </div>

        <div class="form-group">
            {{Form::file("cover_image")}}
        </div>

        {{Form::hidden("_method", "PUT")}}
        {{Form::submit("Submit", ["class" => "btn btn-primary"])}}
    {{ Form::close() }}

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
        
        <button type="submit" class="btn btn-primary">Update Project</button>
           
    </form>
@endsection