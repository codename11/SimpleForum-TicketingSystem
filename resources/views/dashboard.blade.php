@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 10% !important;">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                @include("inc.listOfUsers")

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>
                    
                    @if(Auth::check() && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator" || Auth::user()->rola->role=="user"))
                        <a href="/posts/create" class="btn btn-info">Create post</a>
                    @endif
                    
                    <h3>Your blog posts</h3>
                    
                        @if(count($posts) > 0)
                        <table class="table table striped">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>

                            @foreach ($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                @if(Auth::check() && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator" || Auth::user()->rola->role=="user"))
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                                    <td>
                                        {!!Form::open(["action" => ["PostsController@destroy", $post->id], "method" => "POST", "class" => "float-right"])!!}
                                            {{Form::hidden("_method", "DELETE")}}
                                            {{Form::submit("Delete", ["class" => "btn btn-danger"])}}
                                        {!!Form::close()!!}
                                    </td>
                                @endif
                            </tr>
                            @endforeach

                        </table>
                        @else
                            <p>You have no posts</p>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
