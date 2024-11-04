<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkateSpot extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'latitude', 'longitude', 'category', 'user_id', 'status'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
