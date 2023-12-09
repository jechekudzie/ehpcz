<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccreditedInstitution extends Model
{
    protected $guarded = [];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }
}
