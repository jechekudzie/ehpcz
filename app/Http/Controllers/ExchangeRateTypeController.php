<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRateType;
use Illuminate\Http\Request;

class ExchangeRateTypeController extends Controller
{
    //index
    public function index()
    {
        $exchangeRateTypes = ExchangeRateType::all();
        return view('administration.exchange_rate_types.index', compact('exchangeRateTypes'));
    }

    //create
    public function create()
    {
        return view('administration.exchange_rate_types.create');
    }

    //store
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);

        ExchangeRateType::create($request->all());

        return redirect()->route('exchange-rate-types.index')->with('success', 'Exchange Rate Type created successfully.');
    }

    //edit
    public function edit(ExchangeRateType $exchangeRateType)
    {
        return view('administration.exchange_rate_types.edit', compact('exchangeRateType'));
    }

    //update
    public function update(Request $request, ExchangeRateType $exchangeRateType)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $exchangeRateType->update($request->all());

        return redirect()->route('exchange-rate-types.index')->with('success', 'Exchange Rate Type updated successfully.');
    }

    //destroy
    public function destroy(ExchangeRateType $exchangeRateType)
    {
        $exchangeRateType->delete();

        return redirect()->route('exchange-rate-types.index')->with('success', 'Exchange Rate Type deleted successfully.');
    }
}
