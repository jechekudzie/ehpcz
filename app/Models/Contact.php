<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }
}
