<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('payment_id');
            $table->unsignedInteger('product_id');
            $table->unsignedTinyInteger('units');
            $table->timestamp('consumed_at')->nullable();
            $table->timestamp('created_at')->default('current_timestamp');
            $table->decimal('price', 20, 2)->default(1);

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
}
