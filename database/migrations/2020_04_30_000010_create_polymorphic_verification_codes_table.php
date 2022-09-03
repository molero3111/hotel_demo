<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicVerificationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polymorphic_verification_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('table_name_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('record_id');
            $table->string('code');
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
        Schema::dropIfExists('polymorphic_verification_codes');
    }
}
