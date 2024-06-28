@extends('layouts.admin_practitioner')

@section('content')
    <div class="container mt-4">
        <div class="card">

            <div class="card-header">
                <span class="float-end fs-10">
                 <a style="font-size: 12px; color: white;"
                    href="{{route('renewal.payments.index',$renewal->id)}}"
                    class="btn btn-success fw-medium">
                     <i class="fa fa-arrow-left"></i> Back to {{$renewal->period}} Payments
                 </a>
                </span>
                Payment Summary
            </div>
            <div class="card-body">
                <h5 class="card-title">Thank you for your payment!</h5>
                <p class="card-text">Here are the details of your transaction:</p>
                <table class="table">
                    <tbody>
                    <tr>
                        <th scope="row">Total Amount Invoiced:</th>
                        <td>{{ number_format($payment->total_amount_invoiced, 2) }} {{ $payment->currency->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Amount Paid:</th>
                        <td>{{ number_format($payment->amount_paid, 2) }} {{ $payment->currency->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Balance:</th>
                        <td>{{ number_format($payment->balance, 2) }} {{ $payment->currency->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Payment Method:</th>
                        <td>{{ $payment->paymentMethod->name }}</td>
                    </tr>
                    @if ($payment->proof_of_payment)
                        <tr>
                            <th scope="row">Proof of Payment:</th>
                            <td><a href="{{ asset($payment->proof_of_payment) }}" target="_blank">View Document</a></td>
                        </tr>
                    @endif
                    @if ($payment->reference)
                        <tr>
                            <th scope="row">Reference Number:</th>
                            <td>{{ $payment->reference }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
