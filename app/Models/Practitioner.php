<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practitioner extends Model
{
    protected $guarded = [];

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function employment()
    {
        return $this->hasOne(Employment::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function identificationType()
    {
        return $this->belongsTo(IdentificationType::class);
    }

    public function professions()
    {
        return $this->belongsToMany(Profession::class);
    }

}
