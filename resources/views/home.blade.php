<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SkateSpots</title>
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
                    @auth
                    <a class="nav-link" href="{{ route('profile.show', ['username' => Auth::user()->username]) }}">Profile</a>
                    @endauth    
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
    <h1>Welcome, {{ Auth::user()->username }}!</h1>
    <div class="d-flex justify-content-center align-items-center my-4">
        <button id="add-skate-spot" class="btn btn-primary p-2">Add Skate Spot</button>
    </div>
    <div id="popup-notification" class="alert alert-info text-center" role="alert" style="display: none;">
        Drop marker in map to add a skate spot.
    </div>      
    <div id="map"></div>
    <div class="modal fade" id="skateSpotModal" tabindex="-1" aria-labelledby="skateSpotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="skateSpotModalLabel">Add Skate Spot Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="skate-spot-form" action="{{ route('skate-spots.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Dropdown for Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category" id="category" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="skatepark">Skatepark</option>
                                <option value="skate_shop">Skate Shop</option>
                                <option value="street_spot">Street Spot</option>
                            </select>
                        </div>
    
                        <!-- Title Input -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div id="file-error" class="text-danger" style="display: none;">
                            You cannot upload more than 5 images.
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Upload Images (Up to 5)</label>
                            <input 
                                type="file" 
                                class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                                id="images" 
                                name="images[]" 
                                accept="image/*" 
                                multiple 
                                required
                            >
                            
                            <!-- Error for the array (too many files, not an array, etc.) -->
                            @error('images')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                            
                            <!-- Error for each individual image -->
                            @error('images.*')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="container">
                            <ul class="text-start">
                                <li><strong>Formats:</strong> .jpeg .jpg .heic .png .webp</li>
                                <li><strong>Image size:</strong> 2MB (each)</li>
                              </ul> 
                        </div>
    
                        <!-- Description Input -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <!-- Hidden fields for latitude and longitude -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <button type="submit" id="submit-skate-spot" class="btn btn-success">Save Skate Spot</button>
                        <script src="{{ asset('js/imageVal.js') }}" defer></script>
                        <script>
                            // Pass skate spots data from PHP to JavaScript
                                var skateSpots = @json($skateSpots);
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/map.js') }}" defer></script>
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBkdtxqdCf-scid2G_zSmHhDDOMxkBznvk&callback=initMap"></script>

<!-- Bootstrap JS -->
</body>
</html>
