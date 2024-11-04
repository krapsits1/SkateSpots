<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\error;

class LoginController extends Controller
{
    // Use the AuthenticatesUsers trait
    use AuthenticatesUsers;

    // Add your customizations here

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Override the username() method to support both username and email
    public function username()
    {
        $login = request()->input('login'); // 'login' can be either email or username

        // Determine if the login input is an email or username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);

        return $field;
    }
    public function login(Request $request)
    {
        // Validate the login form input
        $this->validateLogin($request);

        // Find user by the username or email
        $user = User::where($this->username(), $request->input('login'))->first();
        
        // If the user does not exist, return error for incorrect username/email
        if (!$user) {
            return back()->withErrors([
                'login' => 'The provided ' . ($this->username() === 'email' ? 'email' : 'username') . ' does not exist.',
            ])->withInput($request->only('login'));
        }

        // If the user exists, but the password is incorrect
        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors([
                'password' => 'The provided password is incorrect.',
            ])->withInput($request->only('login'));
        }

        // Attempt to log the user in
        if (Auth::attempt($this->credentials($request), $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if the user is admin and redirect
            if ($user->role === 'admin') {

                return redirect()->route('admin.dashboard');
            }
    
            return redirect()->intended($this->redirectPath());
        }        

        // If login attempt failed for another reason, return a generic error
        return back()->withErrors([
            'login' => 'Failed to log in. Please try again.',
        ])->withInput($request->only('login'));
    }

    // Override the credentials method to get username or email
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    // Override the validation logic for login
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }


}
