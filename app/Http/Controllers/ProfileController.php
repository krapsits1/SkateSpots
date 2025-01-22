<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log; // Add this line
use App\Models\SkateSpot; // Assuming you have a SkateSpot model
use App\Models\Review;

class ProfileController extends Controller
{
    public function show($username)
    {
        $authUser = Auth::user()->username;  

        $user = User::where('username', $username)->firstOrFail();
        
        if ($user->role === 'admin') {
            abort(403, 'Access denied');
        }
        if($authUser === $user->username){
 
            $skateSpots = $user->skateSpots()->orderBy('created_at', 'desc')->get(); 
            $selectedSkateSpot = $skateSpots->first();

            $skateSpotCount = $skateSpots->count();
        }else{
            $skateSpots = $user->skateSpots()->where('status', 'approved')->orderBy('created_at', 'desc')->get();
            $selectedSkateSpot = $skateSpots->first();
            $skateSpotCount = $skateSpots->count();
        }
        log::info($user);
        return view('profile', compact('authUser','user', 'selectedSkateSpot','skateSpots', 'skateSpotCount')); 
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile/edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Retrieve the authenticated user
         /** @var User $user */
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'username' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'instagram_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
        ]);

        // Handle profile picture upload
    // Remove profile picture if the checkbox is selected
    if ($request->has('remove_profile_picture') && $user->profile_picture) {
        // Delete the file from storage
        Storage::disk('public')->delete($user->profile_picture);
        // Remove the profile picture from the database
        $user->profile_picture = null;
    }

    // Handle new profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Store the profile picture
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = $profilePicturePath;
    }

    // Remove cover photo if the checkbox is selected
    if ($request->has('remove_cover_photo') && $user->cover_photo) {
        // Delete the file from storage
        Storage::disk('public')->delete($user->cover_photo);
        // Remove the cover photo from the database
        $user->cover_photo = null;
    }

    // Handle new cover photo upload
    if ($request->hasFile('cover_photo')) {
        // Store the cover photo
        $coverPhotoPath = $request->file('cover_photo')->store('cover_photos', 'public');
        $user->cover_photo = $coverPhotoPath;
    }


        // Update other user information
        $user->username = $request->input('username');
        $user->bio = $request->input('bio');
        $user->instagram_link = $request->input('instagram_link');
        $user->facebook_link = $request->input('facebook_link');
        $user->youtube_link = $request->input('youtube_link');

        // Save the updated user model
        $user->save();  // Now using save() to persist changes

        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function showSkateModalForPost($id)
    {
        if(request()->ajax()){
            $selectedSkateSpot = SkateSpot::find($id);
            if (!$selectedSkateSpot) {
                abort(404, 'Skate spot not found');
            }else{
                $selectedSkateSpot = SkateSpot::select(['id', 'title', 'description', 'latitude', 'longitude', 'user_id', 'created_at','status'])
                ->with(['images:id,skate_spot_id,path', 'user:id,username,profile_picture', 'reviews.user:id,username,profile_picture'])->find($id);
               
                $authUser = Auth::user()->username;  

                $modalHtml = view('layouts.userPost', ['selectedSkateSpot' => $selectedSkateSpot])->render();
                return response()->json(['skateSpot' => $selectedSkateSpot , 'modalHtml' => $modalHtml, 'authUser' => $authUser]);
            }

        }
      
    }
}
