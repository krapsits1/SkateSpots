
<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body>
    <nav class="navbar navbar-expand-lg  border navbar-light bg-light" style="min-height: 10vh">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('images/Logo2.svg') }}" alt="Logo" height="60" class="d-inline-block align-text-top" style="min-height: 9vh">
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
                    <a class="nav-link" href="{{ Auth::check () ? route('topSpots') : route('login') }}" >Top Spots</a>
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('logout') }}" 
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
    <main style="min-height: 80vh">
        <div class="container mt-3">
            <h2>Email Verification</h2>
            <p>Before accessing your account, please verify your email address.</p>
            <p>Email verification can appear in "Spam" folder.</p>

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ route('verification.send') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Resend Verification Email</button>
            </form>
        </div>
    </main>

</body>
@include('layouts.footer')

</html>