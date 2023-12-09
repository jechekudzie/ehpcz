<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $guarded = [];

    public function practitioners()
    {
        return $this->hasMany(Practitioner::class);
    }
}
