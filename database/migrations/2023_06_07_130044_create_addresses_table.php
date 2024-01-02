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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practitioner_id');
            $table->unsignedBigInteger('address_type_id');
            $table->unsignedBigInteger('city_id');
            $table->string('address_number')->nullable();
            $table->string('street')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();

           /* $table->foreign('practitioner_id')->references('id')->on('practitioners');
            $table->foreign('address_type_id')->references('id')->on('address_types');
            $table->foreign('city_id')->references('id')->on('cities');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
