<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationCompanionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_companions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_companion_id');
            $table->unsignedBigInteger('reservation_id');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('user_companion_id')->references('id')->on('user_companions');
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
        Schema::dropIfExists('reservation_companions');
    }
}
