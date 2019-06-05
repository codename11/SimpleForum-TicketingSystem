@extends("layouts.app")
@section("content")

    <form method="POST" action="/posts/{{$post_id}}/comments">
        @csrf
        <!-- https://laravel.com/docs/5.7/validation#available-validation-rules -->
        
        <div class="form-group">
            <label for="body">Body:</label>
            <textarea id="ckeditor" class="form-control {{$errBody}}" name="body" placeholder="Post body" required value=""></textarea>
        </div>

        <label class="checkbox" for="blah">Blah</label>
        <input type="checkbox" name="blah" onchange="this.form.submit()">

        <div>
            <button type="submit" class="btn btn-primary">Create comment</button>
        </div>
    </form>
    
@endsection

