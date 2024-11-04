<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                    <a class="nav-link {{ Request::is('skate-spots') ? 'active' : '' }}" href="/skate-spots">Skate spots</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('skateparks') ? 'active' : '' }}" href="/skateparks">Skateparks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
   
    <h1>Welcome to My Website</h1>
    <div class="d-flex justify-content-center align-items-center p-3">
        <!-- If the user is not authenticated, redirect them to the login page -->
        <a href="{{ route('login') }}" class="btn btn-primary p-2" id="add-skate-spot">
            Add Skate Spot
        </a>
    </div>
    
    

    <div id="map"></div>
    <script>
        // Pass skate spots data from the server to the JavaScript
        var skateSpots = @json($skateSpots);
    </script>

    <script src="{{ asset('js/map.js') }}" defer></script>
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBkdtxqdCf-scid2G_zSmHhDDOMxkBznvk&callback=initMap"></script>

<!-- Bootstrap JS -->
</body>
</html>
