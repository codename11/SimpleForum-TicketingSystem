<?php 
    $route = Route::getFacadeRoot()->current()->uri();
?>

<ul class="nav nav-tabs">

    <li class="nav-item">
        <a class="nav-link {{$route=="dashboard" ? "active" : ""}}" href="/dashboard">Dashboard</a>
    </li>
    
    @if(Auth::check() && Auth::user()->rola->role=="administrator")
        <li class="nav-item">
            <a class="nav-link {{$route=="userList" ? "active" : ""}}" href="/userList">User list</a>
        </li>
    @endif

</ul>