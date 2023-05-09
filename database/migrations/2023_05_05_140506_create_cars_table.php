<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->integer('seats')->nullable();
            $table->string('transmission')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('mileage')->nullable();
            $table->integer('year')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
