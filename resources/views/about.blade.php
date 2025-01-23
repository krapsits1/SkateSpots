<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body>
    <nav class="navbar navbar-expand-lg  border navbar-light bg-light">
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
    <div class="container py-5">
        <h1 class="text-center mb-4">About SkateSpots</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-10">

    
                <h3 class="mt-5">How to Add a Skate Spot</h3>
                <ol>
                    <li>
                        <strong>Log In:</strong> To add a skate spot, you must be logged in to your account <a href="{{ route('login') }}">Login</a>. If you don't have an account, you can <a href="{{ route('register') }}">register here</a>.
                    </li>
                    <li>
                        <strong>Click the "Add Skate Spot" Button:</strong> Once logged in, you'll see the "Add Skate Spot" button on the <a href="{{ route('home') }}">Home</a> page or in the navigation menu.
                    </li>
                    <li>
                        <strong>Fill Out the Form:</strong> A form will appear where you need to provide the following details:
                        <ul>
                            <li><strong>Spot Name:</strong> Give your skate spot a descriptive and memorable name.</li>
                            <li><strong>Description:</strong> Provide details about the spot, such as its features, challenges, or what makes it unique.</li>
                            <li><strong>Category:</strong> Select the type of skate spot (e.g., Skatepark, Street Spot, Skate Shop).</li>
                            <li><strong>Photos:</strong> Upload one or more photos of the spot to help other users visualize it.</li>
                        </ul>
                        <p class="text-danger"><strong>Note:</strong> All sections are required. Please ensure the information is accurate and complete before submitting.</p>
                    </li>
                    <li>
                        <strong>Submit:</strong> After filling out the form, click the "Submit" button. Your skate spot will be sent for review.
                    </li>
                </ol>

                <!-- Video Section -->
                <div class="row justify-content-center mt-5">
                    <div class="col-12 col-md-8 text-center">
                        <video controls preload="none" class="img-fluid">
                            <source src="{{ asset('videos/Rec.mov') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            
                <h3 class="mt-5">Admin Verification</h3>
                <p>
                    To maintain the quality and reliability of the information on SkateSpots, all newly added skate spots undergo an admin verification process. Once your submission is reviewed and approved, the skate spot will become visible to the public. This ensures a trustworthy and accurate database for the entire community.
                </p>
                <h3 class="mt-5">Report Issues or Bugs</h3>
                <p>
                    Found an issue or bug while using SkateSpots? We’d love to hear from you so we can improve your experience! Please email us at:
                    <a href="mailto:skatespots@gmail.com" class="text-primary">skatespots@gmail.com</a>
                </p>
                <p>
                    When reporting an issue, please include the following details to help us resolve it quickly:
                </p>
                <ul>
                    <li>A brief description of the issue or bug.</li>
                    <li>Steps to reproduce the problem (if applicable).</li>
                    <li>Your browser and device information (e.g., Chrome on Windows 10, Safari on iPhone).</li>
                    <li>Any relevant screenshots or error messages.</li>
                </ul>

                <h3 class="mt-5">Why SkateSpots?</h3>
                <p>
                    SkateSpots was created by skateboarders, for skateboarders. Our mission is to connect the skateboarding community by sharing valuable information about the best spots to skate. With SkateSpots, you can:
                </p>
                <ul>
                    <li>Discover skateboarding locations near you or in other cities.</li>
                    <li>Share your favorite spots and contribute to the community.</li>
                    <li>Explore detailed reviews, ratings, and photos from fellow skaters.</li>
                </ul>
    
                <p class="mt-4">
                    Thank you for being a part of SkateSpots! Together, we can make skateboarding more accessible and enjoyable for everyone.
                </p>
    
                <h5 class="text-center mt-5">
                    Happy Skateboarding! 🛹
                </h5>
            </div>
        </div>
    </div>
</body>