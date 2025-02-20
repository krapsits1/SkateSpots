<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // Redirect the user to the Google authentication page.
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
    
        // Generate a base username from Google name
        $baseUsername = Str::slug($googleUser->getName(), '_');
    
        // Ensure uniqueness
        $username = $this->generateUniqueUsername($baseUsername);
    
        // Find or create the user
        $user = User::firstOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'username' => $username,
            'password' => bcrypt(Str::random(16)), // Secure random password
        ]);
        
        $user->markEmailAsVerified();

        // Log in the user
        Auth::login($user);
    
        return redirect()->route('home');
    }
    
    /**
     * Generate a unique username
     */
    private function generateUniqueUsername($baseUsername)
    {
        $username = $baseUsername;
        $counter = 1;
    
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }
    
        return $username;
    }
}
    
