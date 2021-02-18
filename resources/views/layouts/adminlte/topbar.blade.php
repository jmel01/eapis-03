<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
        @if (Route::has('login'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @endif

        @if (Route::has('register'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        @endif
        @else
        @if(App\Models\Message::where([['to_id',Auth::id()],['seen',0]])->count() != 0)
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">{{ App\Models\Message::where([['to_id',Auth::id()],['seen',0]])->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                @forelse(App\Models\Message::where([['to_id',Auth::id()],['seen',0]])->orderBy('created_at','DESC')->limit(5)->get() as $message)
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="/storage/users-avatar/{{ App\Models\User::find($message->from_id)->avatar ?? 'avatar.png' }}" alt="User Avatar" class="img-size-50 mr-3 img-circle cover" style="width:50px;height:50px;">
                        <div class="media-body">
                            <h3 class="dropdown-item-title text-primary">
                                {{ App\Models\User::find($message->from_id)->name }}
                                @if($message->attachment)
                                <span class="float-right text-sm text-muted"><i class="fas fa-paperclip"></i></span>
                                @endif
                            </h3>
                            <p class="text-sm">{{ $message->body }}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                @empty
                @endforelse
                <a href="/community" target="_blank" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        @endif

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img class="user-image img-circle cover" alt="User Image" src="/storage/users-avatar/{{Auth::user()->avatar ?? 'avatar.png' }}">
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="/storage/users-avatar/{{Auth::user()->avatar ?? 'avatar.png' }}" class="img-circle elevation-2 cover" alt="User Image">
                    <p>
                        {{ Auth::user()->profile->firstName ?? '' }} {{ Auth::user()->profile->middleName ?? '' }} {{ Auth::user()->profile->lastName ?? '' }}
                        <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('profiles.show', Auth::id())}}" class="btn btn-default btn-flat">Profile</a>
                    <a href="#" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->