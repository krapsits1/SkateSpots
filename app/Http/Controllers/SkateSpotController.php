<?php
namespace App\Http\Controllers;

use App\Models\SkateSpot; // Assuming you have a SkateSpot model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this line
use Illuminate\Support\Facades\Auth; // Ensure you import Auth



class SkateSpotController extends Controller
{
    public function store(Request $request)
    {

        if (!Auth::check()) {
            Log::error('User not authenticated');
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        $userId = Auth::id();
        Log::info('Authenticated user ID:', ['user_id' => $userId]);

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'category' => 'required|string',
            'images' => 'required|array|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Log::info('Validation passed', ['validatedData' => $validatedData]);


    
        // Create the Skate Spot
        $skateSpot = SkateSpot::create([
            'title' => $request->title,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'category' => $request->category,
            'user_id' => $userId,
            'status' => 'pending',
        ]);


        $skateSpot->user_id = Auth::id(); // Get the ID of the authenticated user

        

        // Handle file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('skate_spots', 'public');
    
                // Create an Image record for each uploaded image
                $skateSpot->images()->create(['path' => $path]);
            }
        }
    
        return redirect()->route('home')->with('success', 'Skate spot created successfully!');
    }
    
    public function welcome()
    {
        // Fetch only skate spots with 'approved' status
        $skateSpots = SkateSpot::select('title', 'latitude', 'longitude', 'description')
            ->where('status', 'approved') // Filter for approved skate spots
            ->get();
    
        // Pass the skate spots data to the Blade view
        return view('welcome', compact('skateSpots'));
    }
    
    

    public function destroy($id)
    {
        $skateSpot = SkateSpot::findOrFail($id);

        // Check if the authenticated user is the owner of the skate spot
        if ($skateSpot->user_id === Auth::id()) {
            $skateSpot->delete();
            return redirect()->back()->with('success', 'Skate spot deleted successfully.');
        }

        return redirect()->back()->with('error', 'You are not authorized to delete this skate spot.');
    }
    
}
