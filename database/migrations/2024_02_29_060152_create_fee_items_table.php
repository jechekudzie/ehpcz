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
        Schema::create('fee_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_category_id');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('name');
            $table->decimal('amount', 8, 2)->nullable();
            $table->longText('description')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('fee_items');
    }
};
