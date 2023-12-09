<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $guarded = [];
    public function accreditedInstitutions()
    {
        return $this->hasMany(AccreditedInstitution::class);
    }
}
