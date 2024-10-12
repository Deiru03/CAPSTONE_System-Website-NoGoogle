<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClearanceFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clearance_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uploaded_clearance_id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->timestamps();

            $table->foreign('uploaded_clearance_id')
                  ->references('id')->on('uploaded_clearances')->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('clearance_feedback');
    }
};
