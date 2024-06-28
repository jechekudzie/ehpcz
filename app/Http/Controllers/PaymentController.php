<?php

namespace App\Http\Controllers;

use App\Models\ActiveExchangeRateType;
use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Models\FeeCategory;
use App\Models\FeeItem;
use App\Models\Payment;
use App\Models\PaymentBreakdown;
use App\Models\PaymentMethod;
use App\Models\Practitioner;
use App\Models\ProfessionalQualification;
use App\Models\Renewal;
use Illuminate\Http\Request;
use Paynow\Payments\Paynow;

class PaymentController extends Controller
{
    //index
    public function index(Renewal $renewal)
    {

        $practitioner = $renewal->practitioner;
        $payments = $renewal->payments;
        $paymentMethods = PaymentMethod::all();
        $currencies = Currency::all();
        $feeCategories = FeeCategory::all();
        $feeItems = FeeItem::all();

        return view('practitioners.payments.index', compact('practitioner', 'renewal',
            'payments', 'paymentMethods', 'currencies', 'feeCategories', 'feeItems'));
    }

    //create
    public function create(Renewal $renewal)
    {
        $practitioner = $renewal->practitioner;
        $paymentMethods = PaymentMethod::all();
        $currencies = Currency::all();
        $feeCategories = FeeCategory::all();
        $feeItems = FeeItem::all();
        $exchangeRates = ExchangeRate::all();
        $activeExchangeRateTypes = ActiveExchangeRateType::all();

        return view('practitioners.payments.create', compact('practitioner', 'renewal',
            'paymentMethods', 'currencies', 'feeCategories', 'feeItems', 'exchangeRates', 'activeExchangeRateTypes'));
    }

    //paynow payment store

    public function paynowUpdate($transactionReference)
    {
        //get payment_details from session
        $paymentData = session('payment_details');

        $paymentBreakdowns = session('payment_breakdowns');

        //get practitioner
        $practitioner = Practitioner::find($paymentData['practitioner_id']);
        $renewal = Renewal::find($paymentData['renewal_id']);

        //get payment
        $currency = $paymentData['currency_id'];
        //get payment poll url
        $pollUrl = $paymentData['poll_url'];

        //instance of paynow
        $payNow = $this->payNow($currency, $transactionReference);

        //poll transaction
        $response = $payNow->pollTransaction($pollUrl);
        $status = $response->status();
        $payNowReference = $response->paynowReference();
        $reference = $response->reference();

        //update payment
        if ($status == 'paid' || $status == 'awaitingDelivery' || $status == 'delivered') {

            $payment = new Payment($paymentData);

            // Calculate the balance in the transaction currency
            $remainingBalance = $paymentData['exchange_amount'] - $paymentData['amount_paid'];

            // Check if the selected currency is not USD (assuming '1' is USD)
            if ($currency != 1) {
                $exchangeRate = ExchangeRate::find($paymentData['exchange_rate_id']);
                // Convert the balance back to USD
                $usdBalance = $remainingBalance / $exchangeRate->rate; // Ensure that exchangeRate->rate is not zero
                $payment->balance = $usdBalance;
            } else {
                $payment->balance = $remainingBalance; // No conversion needed if in USD
            }

            $payment['reference'] = $payNowReference;

            $payment->save();

            // After saving the payment, update all other payments' balances to zero
            $previousPayments = $practitioner->payments;

            foreach ($previousPayments as $prevPayment) {
                if ($prevPayment->id != $payment->id) {
                    $prevPayment->balance = 0;
                    $prevPayment->save();
                }
            }
            //save payment breakdowns
            foreach ($paymentBreakdowns as $breakdown) {
                $breakdown['payment_id'] = $payment->id;
                $paymentBreakdown = new PaymentBreakdown($breakdown);
                $paymentBreakdown->save();
            }

            if ($paymentData['professional_qualification_id'] != null) {
                $professionalQualification = ProfessionalQualification::findOrFail($paymentData['professional_qualification_id']);
                $professionalQualification->payments()->attach($payment->id, ['renewal_period' => $renewal->period]);
            }


        }

        return redirect()->route('renewals.payments.summary', ['renewal' => $renewal->id, 'payment' => $payment->id]);

    }

    //sumary
    public function summary(Renewal $renewal,Payment $payment)
    {
        $practitioner = $renewal->practitioner;
        return view('practitioners.payments.payment-summary', compact('payment', 'practitioner', 'renewal'));
    }

    public function payNow($currency, $reference)
    {

        //zwl
        if ($currency == '1') {
            //USD
            /* $payNow = new Paynow(
                 '16178',
                 '9611042b-e7f8-4409-a586-8a7766c4ae5f',
                 'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
                 'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
             );*/

            $payNow = new Paynow(
                '5865',
                '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
            );

        } else {
            /*$payNow = new Paynow(
                '13194',
                '450e0e1a-5792-40ce-b1d7-88168435f042',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
            );*/

            $payNow = new Paynow(
                '5865',
                '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
            );
        }



        return $payNow;

    }

   /* public function store(Request $request, Renewal $renewal)
    {

        $practitionerProfession = $renewal->practitionerProfession;
        $practitioner = $renewal->practitioner;
        $payment = $request->validate([
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'fee_category_id' => 'required|integer|exists:fee_categories,id',
            'professional_qualification_id' => 'nullable|integer|exists:professional_qualifications,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'payment_date' => 'required|date|before_or_equal:today',
            'amount_invoiced' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0|max:' . $request->amount,
            'reference' => 'nullable|string|max:255'
        ]);

        if($payment['currency_id' != 1]){
            //require exchange_rate and exchange_id
             $request->validate([
                'exchange_rate' => 'required|numeric|min:0',
                'exchange_rate_id' => 'required|integer|exists:exchange_rates,id'
            ]);
            //fetch exchange rate
            $exchangeRate = ExchangeRate::find($request->exchange_rate_id);
        }

        if($payment['payment_method_id'] !== 8){
            //if pop file is uploaded use move method to move to a folder
            if ($request->hasFile('pop_file')) {
                $popFile = $request->file('pop_file');
                $popFileName = time() . '.' . $popFile->getClientOriginalExtension();
                $popFile->move(public_path($practitioner->first_name.'_'.$practitioner->last_name.'/proof_of_payments'), $popFileName);
                $payment['pop_file'] = $popFileName;
            }
            //check if exchange_rate is provided


        }




        //$payment = $renewal->payments()->create($request->all());

        return back()->with('success', 'Payment added successfully.');
    }*/

}
