<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCompanionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_companions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('id_number_type');
            $table->unsignedTinyInteger('relation_type_id')->default(1);
            $table->timestamps();
            $table->string('id_number', 15);
            $table->string('name', 40);
            $table->string('lastname', 40);
            $table->timestamp('birth_date');
            $table->string('phone_number]', 25)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('address', 150)->nullable();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('id_number_type')->references('id')->on('id_card_number_types');
            $table->foreign('relation_type_id')->references('id')->on('relation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_companions');
    }
}
