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
        $skateSpots = SkateSpot::select('id', 'latitude', 'longitude')->where('status', 'approved')->get();
        return view('home', compact('skateSpots'));
    }
}
