<?php

namespace App\Http\Controllers;

use App\Models\ActiveExchangeRateType;
use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Models\ExchangeRateType;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    //index
    public function index(ExchangeRateType $exchangeRateType)
    {
        $exchangeRates = $exchangeRateType->exchangeRates;
        $currencies = Currency::all();
        return view('administration.exchange_rates.index', compact('exchangeRates','exchangeRateType','currencies'));
    }


    public function store(Request $request, ExchangeRateType $exchangeRateType)
    {
        // Validate the request data
        $validated = $request->validate([
            'base_currency_id' => 'required|exists:currencies,id',
            'exchange_currency_id' => 'required|exists:currencies,id',
            'rate' => 'required|numeric',
            'effective_date' => 'required|date',
        ]);

        // Create a new exchange rate using the validated data
        $exchangeRate = $exchangeRateType->exchangeRates()->create($validated);

        // Redirect the user with a success message
        return redirect()->route('exchange-rates.index', $exchangeRateType->id)->with('success', 'Exchange rate created successfully.');
    }


    //update
    public function update(Request $request, ExchangeRate $exchangeRate)
    {
        // Validate the request data
        $validated = $request->validate([
            'rate' => 'required|numeric',
            'effective_date' => 'required|date',
        ]);

        // Update the exchange rate using the validated data
        $exchangeRate->update($validated);

        // Redirect the user with a success message
        return redirect()->route('exchange-rates.index', $exchangeRate->exchangeRateType->id)->with('success', 'Exchange rate updated successfully.');
    }

    //destroy
    public function destroy(ExchangeRate $exchangeRate)
    {
        // Delete the exchange rate
        $exchangeRate->delete();

        // Redirect the user with a success message
        return redirect()->route('exchange-rates.index', $exchangeRate->exchangeRateType->id)->with('success', 'Exchange rate deleted successfully.');
    }


    public function getActiveExchangeRate($currencyId, Request $request)
    {
        $baseCurrencyId = 1; // Example ID for USD
        $exchangeCurrencyId = $currencyId; // selected currency
        $date = $request->query('paymentDate');

        $rate = null;
        $exchangeRateType = null;
        $exchangeRateId = null;

        // To get the current or historical exchange rate for the USD/EUR pair
        $exchangeRate = ExchangeRate::getRateForCurrencyPairAndDate($baseCurrencyId, $exchangeCurrencyId, $date);

        if ($exchangeRate){
            $rate = $exchangeRate->rate;
            $exchangeRateType = $exchangeRate->exchangeRateType->name;
            $exchangeRateId = $exchangeRate->id;
        }

        return response()->json([
            'exchange_rate_type' => $exchangeRateType,
            'exchange_rate' => $rate,
            'exchange_rate_id' => $exchangeRateId,
            'payment_date' => $date,

        ]);
    }


}
