<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['skate_spot_id', 'path'];

    public function skateSpot()
    {
        return $this->belongsTo(SkateSpot::class);
    }
}
