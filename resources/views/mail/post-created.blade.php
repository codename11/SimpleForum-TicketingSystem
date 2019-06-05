@component('mail::message')
# New Post: {{$post->title}}

{!!$post->body!!}

@component('mail::button', ['url' => url("/posts/".$post->id)])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
