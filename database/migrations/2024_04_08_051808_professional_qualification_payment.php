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
        Schema::create('professional_qualification_payment', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('professional_qualification_id');
            $table->unsignedBigInteger('payment_id');
            $table->string('renewal_period'); // For example, "2023-2024"
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
        Schema::dropIfExists('penalties');
    }
};
