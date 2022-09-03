<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnderagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('underages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('relation_type_id')->default(1);
            $table->boolean('has_legal_custody')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->string('token',255)->unique()->nullable();
            $table->string('token_verification')->nullable();
            $table->tinyInteger('is_rejected')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('person_id')->references('id')->on('people');
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
        Schema::dropIfExists('underages');
    }
}
