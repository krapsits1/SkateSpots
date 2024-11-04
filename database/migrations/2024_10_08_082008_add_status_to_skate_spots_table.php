<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSkateSpotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skate_spots', function (Blueprint $table) {
            // Add 'status' column with default value 'approved' for existing records
            $table->enum('status', ['pending', 'approved', 'denied'])->default('approved')->after('description');
        });

        // Update the existing records to set them as 'approved'
        \App\Models\SkateSpot::whereNull('status')->update(['status' => 'approved']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skate_spots', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
