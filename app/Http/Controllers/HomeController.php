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
        // Fetch all skate spots from the database
        $skateSpots = SkateSpot::all()->where('status', 'approved');

        // Pass the skate spots to the home view
        return view('home', compact('skateSpots'));
    }
}
