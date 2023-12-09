<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequirementsCategory extends Model
{
    protected $guarded = [];

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }
}
