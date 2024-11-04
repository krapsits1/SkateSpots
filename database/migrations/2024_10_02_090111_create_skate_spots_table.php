<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkateSpotsTable extends Migration
{
    public function up()
    {
        Schema::create('skate_spots', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->decimal('latitude', 10, 8); // Latitude of the skate spot
            $table->decimal('longitude', 11, 8); // Longitude of the skate spot
            $table->string('title'); // Title column
            $table->text('description')->nullable(); // Description column
            $table->string('category'); // Category column (make sure to add this)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key linking to users
            $table->timestamps(); // Created at and updated at timestamps
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('skate_spots');
    }
}
