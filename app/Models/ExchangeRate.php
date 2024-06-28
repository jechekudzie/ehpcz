<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exchangeRateType()
    {
        return $this->belongsTo(ExchangeRateType::class);
    }

    public function baseCurrency()
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    }

    public function exchangeCurrency()
    {
        return $this->belongsTo(Currency::class, 'exchange_currency_id');
    }

    public static function getRateForCurrencyPairAndDate($baseCurrencyId, $exchangeCurrencyId, $date)
    {
        $date = Carbon::parse($date)->toDateString();

        // First, find the active exchange rate type for the date
        $activeExchangeRateType = ActiveExchangeRateType::forDate($date);

        if (!$activeExchangeRateType) {
            return null; // No active exchange rate type found for the given date
        }

        // Now, find the exchange rate using the active exchange rate type and the currency pair
        return ExchangeRate::where('exchange_rate_type_id', $activeExchangeRateType->exchange_rate_type_id)
            ->where('base_currency_id', $baseCurrencyId)
            ->where('exchange_currency_id', $exchangeCurrencyId)
            ->where('effective_date', '<=', $date)
            ->latest('effective_date')
            ->first();
    }


}
