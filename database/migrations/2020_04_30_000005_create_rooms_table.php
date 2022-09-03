<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('room_type_id')->default(1);
            $table->unsignedTinyInteger('room_status_id')->default(1);
            $table->string('room_number',10)->unique();

            $table->foreign('room_type_id')->references('id')->on('room_types');
            $table->foreign('room_status_id')->references('id')->on('room_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
