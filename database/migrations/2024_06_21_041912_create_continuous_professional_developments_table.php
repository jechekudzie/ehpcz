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
        Schema::create('continuous_professional_developments', function (Blueprint $table) {
            $table->id();
            $table->integer('period');
            $table->unsignedBigInteger('renewal_id');
            $table->unsignedBigInteger('practitioner_id');
            $table->integer('points')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('continuous_professional_developments');
    }
};
