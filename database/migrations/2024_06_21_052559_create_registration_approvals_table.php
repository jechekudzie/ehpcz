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
        Schema::create('registration_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_qualification_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('role')->nullable();
            $table->string('status')->nullable();
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('registration_approvals');
    }
};