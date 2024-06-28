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
        Schema::create('renewal_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('renewal_id');
            $table->unsignedBigInteger('certificate_type_id');
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->timestamp('issued_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('renewal_certificates');
    }
};
