<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                    <a class="nav-link " href="{{ route('login') }}">Login</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

    <div class="container d-flex justify-content-center mt-5">
        <div class="card shadow-lg p-4" style="max-width: 900px; width: 100%;">
          <h3 class="text-center mb-4">Register</h3>
      
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
            </div>
          @endif
      
          <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input id="username" type="text" 
                     class="form-control @error('username') is-invalid @enderror" 
                     name="username" value="{{ old('username') }}" required autofocus>
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
      
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input id="email" type="email" 
                     class="form-control @error('email') is-invalid @enderror" 
                     name="email" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
      
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input id="password" type="password" 
                     class="form-control @error('password') is-invalid @enderror" 
                     name="password" required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
      
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
      
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
      
            <div class="text-center mb-3">
                <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                    <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo" width="20" height="20">
                    Register with Google
                </a>
            </div>
      

            <p class="mt-4 mb-4 text-center">Already have an account?<a class="ps-2" href="{{ route('login') }}">Login here</a></p>

            </p>
          </form>
        </div>
      </div>

</body>
</html>
