<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationUnderagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_underages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('underage_id');
            $table->unsignedBigInteger('reservation_id');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('underage_id')->references('id')->on('underages');
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_underages');
    }
}
