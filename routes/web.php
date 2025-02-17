<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkateSpotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\GoogleController;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]); // Enable email verification routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

// Resend Verification Email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home'); // Redirect after successful verification
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/home');
    }
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('This is a test email from Laravel!', function ($message) {
        $message->to('skatesspots@gmail.com') // Replace with your email
                ->subject('Test Email from Laravel');
    });
    return 'Email Sent Successfully!';
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/', [SkateSpotController::class, 'welcome'])->name('welcome');
Route::get('/top-spots', [SkateSpotController::class, 'topSpots'])->name('topSpots');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');



Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('/admin/skate_spots', [AdminController::class, 'showAllSkateSpots'])->name('admin.skateSpots');
    Route::get('/admin/verify-skate-spots', [AdminController::class, 'verifySkateSpots'])->name('admin.verifySkateSpots');
    Route::post('/admin/skate-spots/{id}/approve', [AdminController::class, 'approveSkateSpot'])->name('admin.approveSkateSpot');
    Route::delete('/admin/skate-spots/{id}/deny', [AdminController::class, 'denySkateSpot'])->name('admin.denySkateSpot');
    Route::get('/admin/users/{id}/profile', [AdminController::class, 'showUserProfile'])->name('admin.userProfile');
    Route::get('admin/skate-spot/{id}', [AdminController::class, 'getSkateSpot'])->name('admin.getSkateSpot');


});

Route::middleware(['auth'])->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/{username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/post/{id}', [ProfileController::class, 'showSkateModalForPost'])->name('profile.showSkateModalForPost');
    Route::delete('/skate-spots/{id}/destroy', [SkateSpotController::class, 'destroy'])->name('skateSpots.destroy');

});


// Show registration and login form
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::post('/skate-spots', [SkateSpotController::class, 'store'])->name('skate-spots.store');
});

Route::get('/skate-spot/{id}', [SkateSpotController::class, 'show'])->name('skate-spot.show');
Route::get('home/skate-spot/{id}', [SkateSpotController::class, 'show'])->name('skate-spot.home.show');
// Route::get('home/skate-spot/post/{id}', [SkateSpotController::class, 'showSkateModalForPost'])->name('skate-spot.home.showSkateModalForPost');

Route::post('/skate-spots/{id}/add-review', [SkateSpotController::class, 'addReview'])->name('skate-spots.addReview');
