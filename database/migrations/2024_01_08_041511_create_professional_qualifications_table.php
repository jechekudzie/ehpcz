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
        Schema::create('professional_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practitioner_profession_id');
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->unsignedBigInteger('qualification_category_id')->nullable();//local or foreign
            $table->unsignedBigInteger('qualification_level_id')->nullable();
            $table->unsignedBigInteger('register_id')->nullable();
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->string('qualification_name')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('start_date')->nullable();
            $table->string('completion_date')->nullable();
            $table->string('processed_by')->nullable();//
            $table->boolean('is_verified')->default(0);//0 for unverified, 1 for verified
            $table->boolean('is_current')->default(0);//0 for not current, 1 for current
            $table->boolean('is_active')->default(0);//0 for not current, 1 for current
            $table->unsignedBigInteger('registration_rule_id')->default(0);//registration rule
            $table->boolean('admin')->default(0);
            $table->boolean('accountant')->default(0);
            $table->boolean('registrar')->default(0);
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('professional_qualifications');
    }
};
