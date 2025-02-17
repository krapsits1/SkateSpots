<nav class="navbar navbar-expand-lg border navbar-light bg-light"style="min-height: 10vh">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/Logo2.svg') }}" alt="Logo" class="d-inline-block align-text-top" style="min-height: 9vh">
        </a>
        <!-- Hamburger Menu (for mobile view) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('topSpots') }}">Top Spots</a>
            </li>
            <li class="nav-item">
                @auth
                <a class="nav-link" href="{{ route('profile.show', ['username' => Auth::user()->username]) }}">Profile</a>
                @endauth    
            </li>
            <li class="nav-item">
                @auth
                    <a class="nav-link" href="{{ route('logout') }}" style="border: none; background: none; color: rgb(9, 89, 250);"    
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            
                @guest
                    <a class="nav-link" href="{{ route('login') }}" style="border: none; background: none; color: rgb(9, 89, 250);">Login</a>
                @endguest
            </li>  
        </ul>
        </div>
    </div>
</nav>