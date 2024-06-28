<?php

namespace App\Http\Controllers;

use App\Models\ActiveExchangeRateType;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ActiveExchangeRateTypeController extends Controller
{
    // Activate an ExchangeRateType
    public function activate(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'exchange_rate_type_id' => 'required|exists:exchange_rate_types,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Check if there are any ExchangeRates for the given ExchangeRateType
        $hasExchangeRates = ExchangeRate::where('exchange_rate_type_id', $validated['exchange_rate_type_id'])->exists();

        if (!$hasExchangeRates) {
            // If no ExchangeRates exist for this type, inform the user to create one first
            return redirect()->back()->with('error', 'Please create an Exchange Rate for this type first.');
        }

        // Close previous overlapping periods
        ActiveExchangeRateType::closeOverlappingPeriods($validated['start_date']);

        // Attempt to update an existing record with the same start_date and exchange_rate_type_id
        $activeExchangeRateType = ActiveExchangeRateType::where('exchange_rate_type_id', $validated['exchange_rate_type_id'])
            ->where('start_date', $validated['start_date'])
            ->first();

        if ($activeExchangeRateType) {
            // If an existing record is found, update it
            $activeExchangeRateType->update($validated);
            return redirect()->back()->with('success', 'The exchange rate type has been activated and updated successfully.');
        } else {
            // If no existing record is found, create a new one
            ActiveExchangeRateType::create($validated);
            return redirect()->back()->with('success', 'The exchange rate type has been activated successfully.');
        }
    }

}
