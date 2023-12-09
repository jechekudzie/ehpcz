<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    protected $guarded = [];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
