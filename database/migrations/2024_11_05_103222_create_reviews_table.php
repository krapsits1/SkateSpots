<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Unique identifier for the review
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to the users table
            $table->foreignId('skate_spot_id')->constrained()->onDelete('cascade'); // Foreign key to the skate spots table
            $table->text('content'); // The content of the review
            $table->unsignedTinyInteger('rating'); // Rating, e.g., 1 to 5 stars
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
