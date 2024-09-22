<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClearancesTable extends Migration
{
    public function up()
    {
        Schema::create('clearances', function (Blueprint $table) {
            $table->id();
            $table->string('document_name');
            $table->text('description')->nullable();
            $table->integer('units')->nullable();
            $table->enum('type', ['Permanent', 'Part-Timer', 'Temporary']);
            $table->integer('number_of_requirements')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clearances');
    }
};
