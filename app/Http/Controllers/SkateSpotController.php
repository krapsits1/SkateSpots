<?php
namespace App\Http\Controllers;

use App\Models\SkateSpot; // Assuming you have a SkateSpot model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this line
use Illuminate\Support\Facades\Auth; // Ensure you import Auth
use Illuminate\Support\Facades\Http;

use App\Models\Review;




class SkateSpotController extends Controller
{
    public function store(Request $request)
    {

        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        $userId = Auth::id();

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
    
        return redirect()->route('home')->with('success', 'Skate spot submitted successfully!');
    }
    public function topSpots(Request $request)
    {
        // Fetch top-rated skate spots
        $query = SkateSpot::with(['images', 'user', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating');
    
        // Filter by category if selected
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }
    
        // Search by location if provided
        if ($request->filled('location')) {

            Log::info("Location controller");


            $response = Http::withHeaders([
                'User-Agent' => 'SkateSpots (emilsvetra@email.com)'  // Set your app name and email
            ])->get("https://nominatim.openstreetmap.org/search", [
                'q' => $request->location,
                'format' => 'json',
                'limit' => 1,
            ]);
            
    
            Log::info("repsonse: $response");

            $geoData = $response->json();
    
            if (!empty($geoData)) {
                $latitude = $geoData[0]['lat'];
                $longitude = $geoData[0]['lon'];
                
                Log::info("Geocoded location: $latitude, $longitude");
                
                // Apply a proximity filter (within 50km for example)
                $query->whereRaw("
                    ST_Distance_Sphere(
                        point(longitude, latitude), 
                        point(?, ?)
                    ) < 50000", [$longitude, $latitude]);
            }
        }
    
        // Filter by rating if provided
        if ($request->filled('rating')) {
            $query->having('reviews_avg_rating', '>=', $request->rating);
        }
    
        $topSpots = $query->get(); // Adjust the number of top spots as needed
    
        return view('topSpots', compact('topSpots'));
    }


    public function welcome()
    {
        $skateSpots = SkateSpot::with(['images', 'user'])
            ->where('status', 'approved')
            ->get()
            ->map(function($spot) {
                $spot->date = $spot->created_at->format('Y-m-d H:i');
                $spot->image_paths = $spot->images->map(function($image) {
                    return asset('storage/' . $image->path); // Generate full URL for each image
                });
                return $spot;
            });
    
        return view('welcome', compact('skateSpots'));
    }
    
    
    public function destroy($id)
    {
        Log::info('Destroying skate spot ID: ' . $id);
        $skateSpot = SkateSpot::findOrFail($id);

        // Check if the authenticated user is the owner of the skate spot
        if ($skateSpot->user_id === Auth::id()) {
            $skateSpot->delete();
            Log::info('Skate spot deleted successfully');
            return redirect()->back()->with('success', 'Skate spot deleted successfully.');
        }else{
            Log::info('kaut kas nesagaaja ' . "spot id : " . $id);
            Log::info('kaut kas nesagaaja ' . "user id : " . Auth::id());

        }

        return redirect()->back()->with('error', 'You are not authorized to delete this skate spot.');
    }

    public function show($id)
    {
        if (request()->ajax()) {
            return $this->handleAjaxRequest($id);
        }

        return $this->handleStandardRequest($id);
    }

    protected function handleAjaxRequest($id)
    {
        Log::info('Burrr Handling AJAX request for skate spot ID: ' . $id);


        $skateSpot = SkateSpot::with(['images', 'user','reviews.user'])
            ->where('status', 'approved')
            ->find($id);

        if (!$skateSpot) {
            return response()->json(['error' => 'Skate spot not found'], 404);
        }

        // $skateSpot->load('reviews');


        $modalHtml = view('layouts.skateModal', ['selectedSkateSpot' => $skateSpot])->render();
        return response()->json([
            'skateSpot' => $skateSpot,
            'modalHtml' => $modalHtml
        ]);
    }

    protected function handleStandardRequest($id)
    {
        Log::info('burrrr Handling standard request for skate spot ID: ' . $id);

        $allSkateSpots = SkateSpot::with(['images', 'user'])
            ->where('status', 'approved')
            ->get();

        $selectedSkateSpot = SkateSpot::with(['images', 'user','reviews.user'])->find($id);

        if (!$selectedSkateSpot) {
            abort(404, 'Skate spot not found');
        }

        return view(Auth::check() ? 'home' : 'welcome', [
            'skateSpots' => $allSkateSpots,
            'selectedSkateSpot' => $selectedSkateSpot
        ]);
    }

    
    public function addReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        $skateSpot = SkateSpot::findOrFail($id);

        $skateSpot->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }

    public function showSkateModalForPost($id)
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
