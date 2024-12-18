<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SkateSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function showDashboard()
    {        
        $newSkateSpots = SkateSpot::where('status', 'pending')->get();
        $selectedSkateSpot = $newSkateSpots->first(); // Select the first skate spot as the default
        Log::alert('showDashboard SelectedSkateSpot from admin controller: ' . $selectedSkateSpot); 

        return view('profile.admin.dashboard', compact('newSkateSpots', 'selectedSkateSpot'));
    }

    // Method to display all users with an option to delete them
    public function showUsers()
    {
        $users = User::all();
        $totalUsers = $users->count(); // Get the total count of users

        return view('profile.admin.users', compact('users', 'totalUsers'));
    }

    // Method to delete a user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    // Method to display all skate spots
    public function showAllSkateSpots()
    {
        $skateSpots = SkateSpot::with(['images', 'user'])->orderBy('created_at', 'desc')->get();
        $selectedSkateSpot = $skateSpots->first();
        $totalSkateSpots = $skateSpots->count(); // Get the total count of skate spots

        return view('profile.admin.skate_spots', compact('skateSpots', 'selectedSkateSpot', 'totalSkateSpots'));
    }

    // Method to display newly added skate spots for verification
    public function verifySkateSpots()
    {
        $pendingSkateSpots = SkateSpot::where('status', 'pending')->get(); // Assuming 'status' field exists
        return view('admin.verify_skate_spots', compact('pendingSkateSpots'));
    }

    // Method to approve a skate spot
    public function approveSkateSpot($id)
    {
        $skateSpot = SkateSpot::find($id);
        if ($skateSpot) {
            $skateSpot->status = 'approved'; // Set the skate spot as approved
            $skateSpot->save(); // Save the changes

            return redirect()->route('admin.dashboard')->with('success', 'Skate spot approved successfully.');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Skate spot not found.');
    }

    // Method to deny a skate spot
    public function denySkateSpot($id)
    {
        $skateSpot = SkateSpot::find($id);
        if ($skateSpot) {
            $skateSpot->delete(); // Delete the skate spot if denied

            return redirect()->back()->with('success', 'Skate spot denied successfully.');
        }

        return redirect()->back()->with('error', 'Skate spot not found.');
    }

    // Method to get a specific skate spot
    public function getSkateSpot($id)
    {
        $skateSpot = SkateSpot::with(['images', 'user', 'reviews.user'])->find($id);

        if (!$skateSpot) {
            return response()->json(['error' => 'Skate spot not found'], 404);
        }

        $modalHtml = view('layouts.skateModal', ['selectedSkateSpot' => $skateSpot])->render();
        return response()->json([
            'skateSpot' => $skateSpot,
            'modalHtml' => $modalHtml,
        ]);
    }
}