<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $guarded = [];

    public function practitioners()
    {
        return $this->hasMany(Practitioner::class);
    }
}
