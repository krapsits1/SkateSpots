<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body>
    @include('layouts.homeNav')

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
                        <source src="{{ asset('videos/Addd_skateSpot.mov') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <!-- Admin Verification -->
                <h3 class="mt-5 fw-bold">Admin Verification</h3>
                <p>All newly added spots undergo an admin review to ensure high-quality, reliable content for the community.</p>

                <!-- Report Issues -->
                <h3 class="mt-5 fw-bold">Report Issues or Bugs</h3>
                <p>If you encounter issues, please email us at: 
                    <a href="mailto:skatesspots@gmail.com" class="text-primary fw-bold">skatesspots@gmail.com</a>
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
@include('layouts.footer')

</html>