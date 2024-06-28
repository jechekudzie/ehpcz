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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('period');//extract from payment date (get the year)
            $table->unsignedBigInteger('renewal_id');//which period the payment is for
            $table->unsignedBigInteger('practitioner_id');

            $table->unsignedBigInteger('fee_category_id')->nullable();
            $table->unsignedBigInteger('fee_item_id');

            $table->decimal('amount_invoiced', 15, 2);//amount invoiced in usd
            $table->decimal('total_amount_invoiced', 15, 2);//total amount invoiced in usd
            $table->decimal('exchange_amount', 15, 2);//total exchange amount
            $table->decimal('amount_paid', 15, 2);//amount paid
            $table->decimal('balance', 8, 2)->default(0);

            $table->unsignedBigInteger('currency_id');
            $table->decimal('exchange_rate',15,2)->nullable();
            $table->unsignedBigInteger('exchange_rate_id')->nullable();


            $table->date('payment_date')->nullable();
            $table->unsignedBigInteger('payment_status_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();


            $table->string('poll_url')->nullable();//for paynow transactions
            $table->string('reference')->nullable();//can be ecocash number, transfer number, paynow number etc
            $table->string('proof_of_payment')->nullable();//file path for the uploaded proof of payment
            $table->string('receipt_number')->nullable();//pastel receipt number
            $table->string('mobile_number')->nullable();//mobile number for transaction made via ecocash
            $table->unsignedBigInteger('professional_qualification_id')->nullable();

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
        Schema::dropIfExists('payments');
    }
};
