<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $guarded = [];

    //payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    //fee items
    public function feeItems()
    {
        return $this->hasMany(FeeItem::class);
    }


}
