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
        Schema::create('practitioner_data', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('identification_number');
            $table->unsignedBigInteger('identification_type_id');
            $table->unsignedBigInteger('profession_id');
            $table->unsignedBigInteger('qualification_id');
            $table->string('registration_number');
            $table->unsignedBigInteger('institution_id');
            $table->year('registration_year');
            $table->enum('employment_status', ['employed', 'unemployed']);
            $table->string('current_employer')->nullable();
            $table->unsignedBigInteger('employment_sector_id');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->string('email')->unique();
            $table->string('address');
            $table->string('phone_number');
            $table->string('date_of_birth');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('title_id')->nullable();
            $table->unsignedBigInteger('marital_status_id');
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
        Schema::dropIfExists('practitioner_data');
    }
};
