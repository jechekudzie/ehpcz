<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Paynow\Payments\Paynow;
use Exception;
class AdminController extends Controller
{
    //
    public function initiatePayment(Request $request)
    {
        //generate unique reference
        $reference = 'INV' . strtoupper(uniqid());

        $currentCurrency = 'USD';
        // Initiate the payment and redirect the user
        $payNow = $this->payNow($currentCurrency,$reference);

        // Create a new payment
        $payment = $payNow->createPayment($currentCurrency, 'jechekudzie@gmail.com');

        // Add items to the payment
        $payment->add('Practitioner Payment', 8);

        // Set the payment to be paid using payment methods
        $response = $payNow->send($payment);

        if ($response->success()) {
            $pollUrl = $response->pollUrl();

            return redirect($response->redirectUrl());
        } else {
            throw new Exception('Failed to initiate payment');
        }

    }

    public function payNow($currency,$reference)
    {
        //zwl
        if($currency == 'USD')
        {
            //local rtgs
           $payNow = new Paynow(
                '13194',
                '450e0e1a-5792-40ce-b1d7-88168435f042',
                'http://localhost:8000/paynow/'.$reference,
                'http://localhost:8000/paynow/'.$reference
            );

            //usd
          /* $payNow = new Paynow(
                '16178',
                '9611042b-e7f8-4409-a586-8a7766c4ae5f',
                'http://localhost:8000/paynow/'.$reference,
                'http://localhost:8000/paynow/'.$reference
            );*/
        }
        return $payNow;
    }

    public function index()
    {
        return redirect()->route('practitioners.index');
    }

    public function table()
    {
        return view('administration.table');
    }

    public function form()
    {
        return view('administration.form');
    }

    public function profile()
    {
        return view('administration.profile');
    }

    public function dashboard()
    {
        return view('administration.dashboard');
    }
    public function pickers()
    {
        return view('administration.pickers');
    }
}
