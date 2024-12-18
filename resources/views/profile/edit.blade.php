<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
                    <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">Profile</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Edit Profile</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea name="bio" class="form-control" id="bio">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control" id="profile_picture">
                
                @if ($user->profile_picture)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" width="100">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remove_profile_picture" id="remove_profile_picture">
                            <label class="form-check-label" for="remove_profile_picture">
                                Remove Profile Picture
                            </label>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="mb-3">
                <label for="cover_photo" class="form-label">Cover Photo</label>
                <input type="file" name="cover_photo" class="form-control" id="cover_photo">
                
                @if ($user->cover_photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $user->cover_photo) }}" alt="Cover Photo" width="100">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remove_cover_photo" id="remove_cover_photo">
                            <label class="form-check-label" for="remove_cover_photo">
                                Remove Cover Photo
                            </label>
                        </div>
                    </div>
                @endif
            </div>
            

            <div class="mb-3">
                <label for="instagram_link" class="form-label">Instagram Link</label>
                <input type="url" name="instagram_link" class="form-control" id="instagram_link" value="{{ old('instagram_link', $user->instagram_link) }}">
            </div>

            <div class="mb-3">
                <label for="facebook_link" class="form-label">Facebook Link</label>
                <input type="url" name="facebook_link" class="form-control" id="facebook_link" value="{{ old('facebook_link', $user->facebook_link) }}">
            </div>

            <div class="mb-3">
                <label for="youtube_link" class="form-label">YouTube Link</label>
                <input type="url" name="youtube_link" class="form-control" id="youtube_link" value="{{ old('youtube_link', $user->youtube_link) }}">
            </div>

            <button href="{{ route('profile.show', ['username' => Auth::user()->username]) }}" type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('profile.show', ['username' => Auth::user()->username]) }}" class="btn btn-primary p-2">
                Go back
            </a>
        </form>
    </div>


</body>
</html>
