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
        Schema::create('practitioner_identifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practitioner_id');
            $table->unsignedBigInteger('identificaction_type_id');
            $table->string('identification')->nullable();
            $table->string('identification_file')->nullable();
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
        Schema::dropIfExists('practitioner_identifications');
    }
};
