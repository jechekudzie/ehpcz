<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $guarded = [];

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
