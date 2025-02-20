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
        <h1 class="text-center mb-4">Privacy Policy</h1>
        
        <p>Last updated: <strong>February 2025</strong></p>
        
        <p>Welcome to SkateSpots. Your privacy is important to us. This policy explains how we collect, use, and protect your data.</p>
        
        <h3>1. Information We Collect</h3>
        <ul>
            <li><strong>Personal Information:</strong> When registering, we collect your username, email, and password.</li>
            <li><strong>Usage Data:</strong> We may collect information about how you use our website, including location data (if permitted).</li>
        </ul>
        
        <h3>2. How We Use Your Information</h3>
        <ul>
            <li>To provide and improve our services.</li>
            <li>To verify and secure your account.</li>
            <li>To analyze website performance and enhance user experience.</li>
        </ul>
        
        <h3>3. Data Protection</h3>
        <p>We implement security measures to protect your personal data. However, no method of transmission over the internet is 100% secure.</p>
        
        <h3>4. Third-Party Services</h3>
        <p>We do not sell your personal data. Some third-party tools (e.g., Google Maps, Google Auth) may collect data according to their policies.</p>
        
        <h3>5. Your Rights</h3>
        <p>You have the right to request access, corrections, or deletion of your personal data. Contact us at <a href="mailto:skatespots@gmail.com">skatespots@gmail.com</a>.</p>
        
        <h3>6. Changes to This Policy</h3>
        <p>We may update this policy from time to time. Changes will be posted here.</p>
        
        <h3>Contact Us</h3>
        <p>If you have any questions about this Privacy Policy, email us at <a href="mailto:skatespots@gmail.com">skatesspots@gmail.com</a>.</p>
    </div>
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
