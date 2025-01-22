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
    //Function which creates a new skate spot
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

    //Skate Spots handler for top spots view
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

    //Welcome page handler (vajag tikai skate spot ids un location)
    public function welcome()
    {

        $skateSpots = SkateSpot::select(['id','latitude', 'longitude', 'category'])->where('status', 'approved')->get();
    
        return view('welcome', compact('skateSpots'));
    }
    
    //Sakate spot deletion handler
    public function destroy($id)
    {
        Log::info('Destroying skate spot ID: ' . $id);
        $skateSpot = SkateSpot::findOrFail($id);

        // Check if the authenticated user is the owner of the skate spot
        if ($skateSpot->user_id === Auth::id()) {
            $skateSpot->delete();
            Log::info('Skate spot deleted successfully');
            return redirect()->back()->with('success', 'Skate spot deleted successfully.');
        }
        return redirect()->back()->with('error', 'You are not authorized to delete this skate spot.');
    }

    //Skate spot show handler (skateModal)
    public function show($id)
    {
        $isAjax = request()->ajax() ? 'AJAX' : 'Standard';
        $requestSource = request()->header('Referer', 'Direct Access');
        $requestUrl = request()->fullUrl();
    
        Log::info("Request Type: $isAjax, Source: $requestSource, URL: $requestUrl");
    
        if (request()->ajax()) {
            return $this->handleAjaxRequest($id);
        }

        return $this->handleStandardRequest($id);
    }

    //Skate spot show handler for ajax request
    protected function handleAjaxRequest($id)
    {
        $selectedSkateSpot = SkateSpot::find($id);
        $authUser = Auth::check();
        if (!$selectedSkateSpot) {
            abort(404, 'Skate spot not found');
        }else{
            $selectedSkateSpot = SkateSpot::select(['id', 'title', 'description', 'latitude', 'longitude', 'user_id', 'created_at'])
            ->with(['images:id,skate_spot_id,path', 'user:id,username,profile_picture', 'reviews.user:id,username,profile_picture'])->find($id);
        }
        //view layouts.skateModal
        $modalHtml = view('layouts.skateModal', ['selectedSkateSpot' => $selectedSkateSpot])->render();
        //Jāsūta arī modelis.
        return response()->json(['skateSpot' => $selectedSkateSpot ,'authUser' => $authUser, 'modalHtml' => $modalHtml]);
    }
    
    //Skate spot show handler for standard request
    protected function handleStandardRequest($id)
    {
        $selectedSkateSpot = SkateSpot::find($id);
    
        if (!$selectedSkateSpot) {
            abort(404, 'Skate spot not found');
        }else{
            $selectedSkateSpot = SkateSpot::select(['id', 'title', 'description', 'latitude', 'longitude', 'user_id', 'created_at'])
            ->with(['images:id,skate_spot_id,path', 'user:id,username,profile_picture', 'reviews.user:id,username,profile_picture'])->find($id);
        }
        
        $skateSpots = SkateSpot::select(['id','latitude', 'longitude'])->where('status', 'approved')->get();

        return view(Auth::check() ? 'home' : 'welcome', [
            'selectedSkateSpot' => $selectedSkateSpot,
            'skateSpots' => $skateSpots
        ]);
    }

    //Skate spot review handler
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
    
}
