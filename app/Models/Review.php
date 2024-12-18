<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'skate_spot_id', 'content', 'rating'];

    // Relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to the SkateSpot model
    public function skateSpot()
    {
        return $this->belongsTo(SkateSpot::class);
    }
}
