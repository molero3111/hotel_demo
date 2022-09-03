<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedSmallInteger('bank_account_id');
            $table->unsignedTinyInteger('payment_type_id');
            $table->string('accountable_code', 30)->nullable();
            $table->decimal('total', 20, 2)->default(0);
            $table->string('reference_number', 60)->unique();
            $table->timestamp('paid_at', 0)->nullable();
            $table->unsignedInteger('movement_currency_id')->nullable();
          

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('movement_currency_id')->references('id')->on('movement_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_movements');
    }
}
