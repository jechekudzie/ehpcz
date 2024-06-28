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
        Schema::create('profession_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profession_id');
            $table->unsignedBigInteger('fee_item_id');
            $table->decimal('amount', 8, 2);
            $table->timestamps();

            $table->foreign('profession_id')->references('id')->on('professions')->onDelete('cascade');
            $table->foreign('fee_item_id')->references('id')->on('fee_items')->onDelete('cascade');

            // Optional: To ensure each combination of profession_id and fee_item_id is unique
            $table->unique(['profession_id', 'fee_item_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profession_fees');
    }
};
