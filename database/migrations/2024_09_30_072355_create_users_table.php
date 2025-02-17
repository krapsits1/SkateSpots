<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email');
            $table->string('password');
            $table->string('profile_picture')->nullable(); // Profile picture field
            $table->string('cover_photo')->nullable(); // Cover photo field
            $table->text('bio')->nullable(); // Bio field
            $table->string('instagram_link')->nullable(); // Instagram link
            $table->string('facebook_link')->nullable(); // Facebook link
            $table->string('youtube_link')->nullable(); // YouTube link
            $table->timestamp('email_verified_at')->nullable();

            $table->timestamps(); // Created at and updated at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users'); // Drops the users table
    }
};
