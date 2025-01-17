<?php

namespace App\Http\Controllers;

use App\Models\SkateSpot; // Make sure to import your model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //vajag tikai skate spot ids un location
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

        // Pass the skate spots to the home view
        return view('home', compact('skateSpots'));
    }
}
