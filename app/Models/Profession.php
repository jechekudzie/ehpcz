<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    protected $guarded = [];

    public function practitioners()
    {
        return $this->belongsToMany(Practitioner::class);
    }

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

}
