<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('locality_id');
            $table->unsignedTinyInteger('id_card_number_type_id')->default(2);
            $table->string('id_number', 20)->unique();
            $table->string('name', 40);
            $table->string('lastname', 40);
            $table->string('address', 150)->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->date('birth_date');
            $table->timestamps();

            $table->foreign('locality_id')->references('id')->on('localities');
            $table->foreign('id_card_number_type_id')->references('id')->on('id_card_number_types');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
