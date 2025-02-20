<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller

{
    use RegistersUsers;


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::debug('Registering user');
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Log::debug('Data validated user');
        Log::debug('Registering user');

        $user = User::create([
            
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Session::flash('success', 'Registration successful! Please login');
        Log::debug('Registered event fired');

        event(new Registered($user)); // Send verification email

        Auth::login($user);

        return view('auth.verify-email');
        
    }
}
