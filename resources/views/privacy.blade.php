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
        <h1>Privacy Policy</h1>
    
        <p><strong>Effective Date:  </strong>21.02.2025</p>
    
        <p>At skatesspots.eu, we value your privacy and are committed to protecting your personal data. This Privacy Policy outlines the types of personal data we collect, how we use it, and how we protect your information. By using our website, you consent to the collection and use of your personal data as described in this policy.</p>
    
        <h4>1. Information We Collect</h4>
        <p>When you register on our website, we collect the following personal information:</p>
        <ul>
            <li><strong>Username:</strong> A unique identifier for your account.</li>
            <li><strong>Email Address:</strong> To communicate with you and send account-related notifications.</li>
            <li><strong>Password:</strong> For securing your account.</li>
            <li><strong>Profile Picture (Optional):</strong> To personalize your profile.</li>
            <li><strong>Cover Photo (Optional):</strong> To personalize your profile.</li>
            <li><strong>Bio (Optional):</strong> A short description about you.</li>
            <li><strong>Social Media Links (Optional):</strong> Instagram, Facebook, and YouTube links if provided.</li>
            <li><strong>Email Verified Timestamp:</strong> We store this timestamp for verification purposes.</li>
        </ul>
        <p>We also collect information when you sign up via Google. In this case, we collect your Google account data (such as your Google ID and email) as part of the authentication process. We do not store your Google account password.</p>
    
        <h4>2. Cookies</h4>
        <p>Our website uses necessary cookies to ensure the website functions correctly. These cookies include:</p>
        <ul>
            <li><strong>Session Cookies:</strong> Used to maintain your session while browsing the site.</li>
            <li><strong>CSRF Token Cookies:</strong> Used to protect you from cross-site request forgery (CSRF) attacks.</li>
        </ul>
        <p>These cookies are essential for the security and functionality of the website, and by using the website, you consent to their use.</p>
    
        <h4>3. Use of Google Maps</h4>
        <p>Our website may display Google Maps. By using Google Maps, you consent to Google’s privacy policy and terms of service. For more details, please review <a href="https://policies.google.com/privacy" target="_blank">Google's Privacy Policy</a>.</p>
    
        <h4>4. How We Use Your Information</h4>
        <p>We use your personal information for the following purposes:</p>
        <ul>
            <li>To create and manage your account.</li>
            <li>To allow you to personalize your profile.</li>
            <li>To send you important account-related notifications (e.g., email verification).</li>
            <li>To enhance your user experience on our platform.</li>
            <li>To display your social media links if you choose to provide them.</li>
        </ul>
        <p>We will not share your personal information with third parties unless required by law or with your consent.</p>
    
        <h4>5. Data Security</h4>
        <p>We take reasonable steps to protect the information you provide to us. However, please note that no method of internet transmission or electronic storage is 100% secure. While we use industry-standard security measures, we cannot guarantee the absolute security of your data.</p>
    
        <h4>6. Your Rights</h4>
        <p>Under the General Data Protection Regulation (GDPR), if you are located in the European Union, you have the following rights regarding your personal data:</p>
        <ul>
            <li>The right to access the data we hold about you.</li>
            <li>The right to request the correction of any incorrect or incomplete data.</li>
            <li>The right to request the deletion of your data.</li>
            <li>The right to restrict the processing of your data.</li>
            <li>The right to object to the processing of your data.</li>
            <li>The right to data portability.</li>
        </ul>
        <p>To exercise any of these rights, please contact us at <a href="mailto:skatesspots@gmail.com">skatesspots@gmail.com</a>.</p>
    
        <h4>7. Third-Party Links</h4>
        <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices or the content of these external sites. Please review the privacy policies of any third-party sites before providing them with your personal information.</p>
    
        <h4>8. International Data Transfers</h4>
        <p>While SkateSSpots.eu is based in the EU, the website may be used worldwide. By using the website, you acknowledge and agree that your data may be transferred and processed in countries outside the European Economic Area (EEA) where privacy laws may not be as protective as those in your jurisdiction.</p>
    
        <h4>9. Changes to This Privacy Policy</h4>
        <p>We reserve the right to update this Privacy Policy at any time. Any changes will be posted on this page with an updated “Effective Date.” We encourage you to review this policy periodically to stay informed about how we protect your personal information.</p>
    
        <h4>10. Contact Us</h4>
        <p>If you have any questions about this Privacy Policy or how your personal data is handled, please contact us at  <a href="mailto:skatesspots@gmail.com">skatesspots@gmail.com</a>.</p>
    
        <p>By using our website, you agree to this Privacy Policy. If you do not agree with this policy, please do not use our website.</p>
    </div>
    </body>
    </html>
    
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
