<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include('layouts.homeNav')

    <main style = "min-height: 75vh">
        <div class="container-fluid p-0 position-relative">
            <!-- Responsive Banner Image -->
            <img src="{{ $user->cover_photo ? asset('storage/' . $user->cover_photo) : asset('images/banner.jpg') }}" 
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
                    <a href="{{ $user->instagram_link }}" target="_blank" id = "instagramIcon">
                        <img src="{{ asset('images/instagram.svg') }}" alt="Instagram" class="social-icon">
                    </a>
                @endif
                @if ($user->facebook_link)
                    <a href="{{ $user->facebook_link }}" target="_blank" id = "facebookIcon">
                        <img src="{{ asset('images/facebook.svg') }}"  alt="Facebook" class="social-icon">
                    </a>
                @endif
                @if ($user->youtube_link)
                    <a href="{{ $user->youtube_link }}" target="_blank" id = "youtubeIcon">
                        <img src="{{ asset('images/youtube.svg') }}"  alt="YouTube" class="social-icon">
                    </a>
                @endif
            </div>
        </div>
        @if($user->id == Auth::id())    
            </div>
                <!-- You can add skate-spots content here -->
                <div class="container p-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary p-2 me-2">
                        Edit Profile
                    </a>
                </div>
            </div>
        @endif
        <div class="container p-4">
            <h5>Bio:</h5>
            @if ($user->bio)
                <p class="user-bio">{{ $user->bio }}</p>
            @else
                <p class="user-bio text-muted">No bio available.</p>
            @endif
        </div>
        <div class="container px-4">
            <h5>Skate Spots: {{ $skateSpotCount }}</h5>
        </div>
        <div id="profilePosts">
            <div class="container px-4">
                <div class="row g-2">
                    @foreach($skateSpots as $skateSpot)
                        <div class="col-4">
                            <div class="post">
                                @if($skateSpot->images->isNotEmpty())
                                    <div class="skateSpotPost image-container" data-id="{{ $skateSpot->id }}">
                                        <img src="{{ asset('storage/' . $skateSpot->images->first()->path) }}" alt="{{ $skateSpot->title }}" class="img-fluid">
                                    </div>
                                @else
                                    <div class="image-container">
                                        <p>No image available.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        @include('layouts.userPost')
        
    </main>
    <script src="{{ asset('js/userProfile.js') }}" defer></script>
    <script src="{{ asset('js/reviewModal.js') }}" defer></script>
    <script src="{{ asset('js/skateModal.js') }}" defer></script>

</body>
@include('layouts.footer')
</html>
