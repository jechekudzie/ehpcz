<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    protected $guarded = [];

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }
}
