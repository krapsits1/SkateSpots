<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
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
                    <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">Profile</a>
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
    <div class="container-fluid p-0 position-relative">
        <!-- Responsive Banner Image -->
        <img src="{{ $user->cover_photo ? asset('storage/' . $user->cover_photo) : asset('images/image.png') }}" 
        class="img-fluid w-100" alt="Responsive Banner" style="height: 300px; object-fit: cover;">
        <!-- Overlay for Profile Image and Username -->
        <div class="d-flex align-items-center position-absolute top-0 start-0 m-3">
            <!-- Profile Image Container with Background -->
            <div class="profile-image-container me-3">
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/person.svg') }}" 
                     alt="Profile Picture" class="profile-image">
            </div>
        
            <!-- Username -->
            <div class="username-container">
                <h5 class="username">{{ $user->username }}</h5>
            </div>
        </div>
        <div class="social-icons-container position-absolute bottom-0 start-0 m-3">
            @if ($user->instagram_link)
                <a href="{{ $user->instagram_link }}" target="_blank">
                    <img src="{{ asset('images/instagram.svg') }}" alt="Instagram" class="social-icon">
                </a>
            @endif
            @if ($user->facebook_link)
                <a href="{{ $user->facebook_link }}" target="_blank">
                    <img src="{{ asset('images/facebook.svg') }}" alt="Facebook" class="social-icon">
                </a>
            @endif
            @if ($user->youtube_link)
                <a href="{{ $user->youtube_link }}" target="_blank">
                    <img src="{{ asset('images/youtube.svg') }}" alt="YouTube" class="social-icon">
                </a>
            @endif
        </div>
    </div>
    <div class="container p-4">
        <h5>Bio:</h5>
        @if ($user->bio)
            <p class="user-bio">{{ $user->bio }}</p>
        @else
            <p class="user-bio text-muted">No bio available.</p>
        @endif
    </div>
    <div class="container p-4" style="overflow-x:auto;">
        <h5>My Skate Spots</h5>
        
        @if($skateSpots->isEmpty())
            <p>You have not added any skate spots yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Images</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($skateSpots as $skateSpot)
                    <tr>
                        <td>{{ $skateSpot->category }}</td>
                        <td>{{ $skateSpot->title }}</td>
                        <td>
                            @if($skateSpot->images->isNotEmpty())
                                <div id="carousel-{{ $skateSpot->id }}" class="carousel slide" data-bs-ride="carousel" >
                                    <div class="carousel-inner" style = "width:200px">
                                        @foreach($skateSpot->images as $key => $image)
                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100" alt="{{ $skateSpot->title }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $skateSpot->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $skateSpot->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @else
                                <p>No images available.</p>
                            @endif
                        </td>
                        <td>{{ $skateSpot->description }}</td>
                        <td>{{ $skateSpot->status }}</td>
                        <td>
                            <form action="{{ route('skateSpots.destroy', $skateSpot->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this skate spot?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
        <!-- You can add skate-spots content here -->
    
        <div class="container p-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary p-2 me-2">
                Edit Profile
            </a>
        </div>
    </div>
    
    



</body>
</html>
