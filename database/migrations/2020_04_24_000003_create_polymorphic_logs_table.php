<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polymorphic_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedTinyInteger('table_name_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('record_id');
            $table->text('data');
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transaction_types');
            $table->foreign('table_name_id')->references('id')->on('table_names');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polymorphic_logs');
    }
}
