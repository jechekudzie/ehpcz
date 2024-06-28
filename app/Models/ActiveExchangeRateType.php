<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ActiveExchangeRateType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exchangeRateType()
    {
        return $this->belongsTo(ExchangeRateType::class);
    }

    public static function forDate($date)
    {
        $date = Carbon::parse($date)->toDateString();

        return self::where('start_date', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->where('end_date', '>=', $date)
                    ->orWhereNull('end_date');
            })->first();
    }

    public static function closeOverlappingPeriods($newStartDate)
    {
        $newStartDate = Carbon::parse($newStartDate)->startOfDay();

        // Find all active periods that would overlap with the new period
        ActiveExchangeRateType::whereNull('end_date')
            ->orWhere('end_date', '>=', $newStartDate)
            ->update(['end_date' => $newStartDate->copy()->subDay()]);
    }



}
