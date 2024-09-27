<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedClearancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shared_clearances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clearance_id');
            $table->timestamps();

            $table->foreign('clearance_id')->references('id')->on('clearances')->onDelete('cascade');

            // To ensure a clearance is shared only once
            $table->unique('clearance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_clearances');
    }
};
