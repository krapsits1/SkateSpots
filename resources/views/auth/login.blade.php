<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="#" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg border navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('welcome') }}">
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
                    <a class="nav-link" href="{{ route('login') }}" style="border: none; background: none; color: rgb(9, 89, 250);">Login</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="container d-flex justify-content-center mt-5">
        <div class="card shadow-lg p-4" style="max-width: 900px; width: 100%;">
            <h3 class="text-center mb-4">Login</h3>
    
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
    
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
    
                <div class="mb-3">
                    <label for="login" class="form-label">Email or Username</label>
                    <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" autocomplete="username" required autofocus>
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
    
                <div class="text-center">
                    <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                        <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo" width="20" height="20">
                        Log in with Google
                    </button>
                </div>
    
                <p class="mt-4 mb-4 text-center">Don't have an account? <a class="ps-2" href="{{ route('register') }}">Register here</a></p>
            </form>
        </div>
    </div>
</body>
</html>
