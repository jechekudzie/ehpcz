<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exchange_rate_type_id');
            $table->unsignedBigInteger('base_currency_id');
            $table->unsignedBigInteger('exchange_currency_id');
            $table->decimal('rate', 15, 2);
            $table->date('effective_date');
            $table->timestamps();

            $table->foreign('exchange_rate_type_id')->references('id')->on('exchange_rate_types');
            $table->foreign('base_currency_id')->references('id')->on('currencies');
            $table->foreign('exchange_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
};
