<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/Logo2.svg') }}" alt="Logo" height="60" class="d-inline-block align-text-top">
        </a>
        <!-- Hamburger Menu (for mobile view) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link"href = "{{route('admin.dashboard')}}"> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"href = "{{route('admin.skateSpots')}}"> SkateSpots</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.users')}}">Users</a>
            </li>
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="nav-link" type="submit" style="border: none; background: none; color: rgb(9, 89, 250);">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
        </div>
    </div>
</nav>