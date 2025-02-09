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
        <h1 class="text-center mb-4 fw-bold">About SkateSpots</h1>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <!-- How to Add a Skate Spot -->
                <h3 class="mt-5 fw-bold">How to Add a Skate Spot</h3>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">
                        <strong>Log In:</strong> You must be logged in to add a skate spot. <a href="{{ route('login') }}" class="text-decoration-none">Login</a> or 
                        <a href="{{ route('register') }}" class="text-decoration-none">Register</a>.
                    </li>
                    <li class="list-group-item">
                        <strong>Click "Add Skate Spot":</strong> Once logged in, you'll find the button on the <a href="{{ route('home') }}" class="text-decoration-none">Home</a> page.
                    </li>
                    <li class="list-group-item">
                        <strong>Fill Out the Form:</strong> Provide the following details:
                        <ul class="mt-2">
                            <li><strong>Spot Name:</strong> Give a unique, descriptive name.</li>
                            <li><strong>Description:</strong> Share key features, challenges, and uniqueness.</li>
                            <li><strong>Category:</strong> Choose from Skatepark, Street Spot, or Skate Shop.</li>
                            <li><strong>Photos:</strong> Upload images for better visualization.</li>
                        </ul>
                        <p class="text-danger"><strong>Note:</strong> Ensure all information is accurate before submission.</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Submit:</strong> Click the "Submit" button to send for review.
                    </li>
                </ol>

                <!-- Video Section -->
                <div class="ratio ratio-16x9 mt-4">
                    <video controls>
                        <source src="{{ asset('videos/Recording.mov') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <!-- Admin Verification -->
                <h3 class="mt-5 fw-bold">Admin Verification</h3>
                <p>All newly added spots undergo an admin review to ensure high-quality, reliable content for the community.</p>

                <!-- Report Issues -->
                <h3 class="mt-5 fw-bold">Report Issues or Bugs</h3>
                <p>If you encounter issues, please email us at: 
                    <a href="mailto:skatespots@gmail.com" class="text-primary fw-bold">skatespots@gmail.com</a>
                </p>
                <p>For faster resolution, include:</p>
                <ul>
                    <li>A brief issue description.</li>
                    <li>Steps to reproduce the problem.</li>
                    <li>Your browser and device information.</li>
                    <li>Relevant screenshots or error messages.</li>
                </ul>

                <!-- Why SkateSpots? -->
                <h3 class="mt-5 fw-bold">Why SkateSpots?</h3>
                <p>Created by skateboarders, for skateboarders! SkateSpots helps you:</p>
                <ul>
                    <li>Find top skateboarding spots near you.</li>
                    <li>Share locations and contribute to the community.</li>
                    <li>See detailed reviews, ratings, and photos.</li>
                </ul>

                <p class="mt-4 text-center">
                    Thank you for being part of SkateSpots! 🛹
                </p>
            </div>
        </div>
    </div>      
</body>