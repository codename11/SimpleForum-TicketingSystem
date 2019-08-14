@extends("layouts.app")

@section("content")

    <div class="container">

        @if(count($profiles) > 0)

            @foreach ($profiles as $profile)
                
                <div class="card" style="width:400px;margin-left: auto;margin-right: auto;">
                    <img class="card-img-top" src="/storage/cover_images/{{$profile->avatar}}" alt="Card image" style="width:100%">
                    <div class="card-body">
                        <h4 class="card-title">{{$profile->name}}</h4>
                        <p class="card-text">
                            Number of posts: {{count($profile->posts)}}<br>
                            Number of comments: {{count($profile->comments)}}<br>
                        </p>
                        <a href="/profile/{{$profile->id}}" class="btn btn-outline-primary">See Profile</a>
                    </div>
                </div>

            @endforeach

        @endif

    </div>
@endsection