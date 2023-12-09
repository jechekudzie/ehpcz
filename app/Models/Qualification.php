<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $guarded = [];

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function accreditedInstitutions()
    {
        return $this->hasMany(AccreditedInstitution::class);
    }

}
