<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRateType extends Model
{
    use HasFactory;

    protected $guarded = [];

    //exchange rates
    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class);
    }

    //active exchange rates
    public function activeExchangeRateTypes()
    {
        return $this->hasMany(ActiveExchangeRateType::class);
    }

    public function isActive()
    {
        $today = now()->toDateString();
        return ActiveExchangeRateType::where('exchange_rate_type_id', $this->id)
            ->where('start_date', '<=', $today)
            ->where(function ($query) use ($today) {
                $query->where('end_date', '>=', $today)
                    ->orWhereNull('end_date');
            })->exists();
    }

}
