<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    //belongs to practitioner
    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    //belongs to renewal
    public function renewal()
    {
        return $this->belongsTo(Renewal::class);
    }

    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class);
    }
    public function feeItem()
    {
        return $this->belongsTo(FeeItem::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }

    public function professionalQualifications()
    {
        return $this->belongsToMany(ProfessionalQualification::class, 'professional_qualification_payment')
            ->withPivot(['renewal_period'])
            ->withTimestamps();
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function breakdowns()
    {
        return $this->hasMany(PaymentBreakdown::class);
    }



}
