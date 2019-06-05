@extends("layouts.app")

@section("content")
    <h1>Create Posts</h1> 
    {{ Form::open(["action" => "PostsController@store", "method" => "post", "enctype" => "multipart/form-data"]) }}
        @csrf
        <div class="form-group">
            {{Form::label("title","Title")}}
            {{Form::text("title","",["class" => "form-control", "placeholder" => "Title"])}}
        </div>

        <div class="form-group">
            {{Form::label("body","Body")}}
            {{Form::textarea("body","",["class" => "form-control", "placeholder" => "Body text", "id" => "ckeditor"])}}
        </div>

        <div class="form-group">
            {{Form::file("cover_image")}}
        </div>

        {{Form::submit("Submit", ["class" => "btn btn-primary"])}}
    {{ Form::close() }}

    <form method="POST" action="/posts">
        @csrf
        <!-- https://laravel.com/docs/5.7/validation#available-validation-rules -->
        <div class="form-group">
            <label for="title">Title:</label>                                   <!--Ovo u 'value' atributu da prilikom neuspesne validacije zapamti staru vrednsot iz polja.-->
        <input class="form-control" type="text" name="title" placeholder="Post title" required value="">
        </div>
        <div class="form-group">
            <label for="body">Body:</label>
            <textarea id="ckeditor" class="form-control" name="body" placeholder="Post body" required></textarea>
        </div>

        <div class="form-group">
            <input type="file" name="cover_image" id="cover_image">
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Create post</button>
        </div>
    </form>
@endsection