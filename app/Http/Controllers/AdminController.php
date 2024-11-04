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

        return view('profile.admin.dashboard', compact('newSkateSpots'));
    }
    // Method to display all users with an option to delete them
    public function showUsers()
    {
        $users = User::all();
        return view('profile.admin.users', compact('users'));
    }

    // Method to delete a user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    // In SkateSpot.php model


    // Method to display all skate spots
    public function showAllSkateSpots()
    {
        $skateSpots = SkateSpot::with('images')->orderBy('created_at', 'desc')->get();
        return view('profile.admin.skate_spots', compact('skateSpots'));
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

            return redirect()->route('admin.skateSpots')->with('success', 'Skate spot denied successfully.');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Skate spot not found.');
    }
}
