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
        Schema::create('qualification_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_qualification_id');
            $table->unsignedBigInteger('requirement_id');
            $table->string('file')->nullable();
            $table->integer('status')->default(0);// required, not required, pending, approved, rejected
            $table->boolean('is_approved')->default(0);//0 for unapproved, 1 for approved
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
        Schema::dropIfExists('qualification_files');
    }
};
