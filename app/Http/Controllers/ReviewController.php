<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\SkateSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $skateSpotId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5', // Ensure rating is between 1 and 5
        ]);

        Review::create([
            'user_id' => Auth::id(), // Get the authenticated user's ID
            'skate_spot_id' => $skateSpotId,
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }

}
