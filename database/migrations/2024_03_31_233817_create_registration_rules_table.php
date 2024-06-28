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
        Schema::create('registration_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('register_id');
            $table->foreign('register_id')->references('id')->on('registers');
            $table->boolean('is_zimbabwean');
            $table->unsignedBigInteger('qualification_category_id');
            $table->foreign('qualification_category_id')->references('id')->on('qualification_categories'); // Assumes a 'qualification_categories' table exists
            $table->unsignedBigInteger('fee_item_id');
            $table->foreign('fee_item_id')->references('id')->on('fee_items');
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
        Schema::dropIfExists('registration_rules');
    }
};
