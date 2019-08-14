<nav id="myNavbar" class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
  <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          
          <ul class="navbar-nav mr-auto">

          </ul>

          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/services">Services</a>
            </li>
            @if(Auth::check() && Auth::user()->status==1 && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator" || Auth::user()->rola->role=="user") && Auth::user()->status===1)
              <li class="nav-item">
                <a class="nav-link" href="/posts">Blog</a>
              </li>
            @endif
            @if(Auth::check() && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator" || Auth::user()->rola->role=="user") && Auth::user()->status===1)
            <li class="nav-item">
              <a class="nav-link" href="/posts/create">Create Post</a>
            </li>
            @endif

            @if(Auth::check() && (Auth::user()->rola->role=="administrator" || Auth::user()->rola->role=="moderator" || Auth::user()->rola->role=="user") && Auth::user()->status===1)
            <li class="nav-item">
              <a class="nav-link" href="/profile/{{auth()->user()->id}}">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/profiles">Profile List</a>
            </li>
            @endif
          </ul>

          <ul class="navbar-nav ml-auto">
              
              <li class="nav-item"><a id="clock" class="nav-link clock"></a></li>
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                    
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          <img src="/storage/cover_images/{{Auth::user()->avatar}}" class="dashImg"> {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/dashboard">Dashboard</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="DisplayNone">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>

