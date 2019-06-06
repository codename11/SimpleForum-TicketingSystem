<form action="/posts/{{$post->id}}/comments/{{$comms[$i]->id}}" method="POST" class="float-right" id="unDelete{{$par->id}}">
    @csrf
    @method('patch')
    
    <button type="submit" class="btn btn-outline-danger btn-sm smaller">Delete</button>

</form>