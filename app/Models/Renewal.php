<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    use HasFactory;

    protected $guarded = [];

    //payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    //practitioner
    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    //practitioner profession
    public function practitionerProfession()
    {
        return $this->belongsTo(PractitionerProfession::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }


    public function renewalStatus()
    {
        return $this->belongsTo(RenewalStatus::class);
    }

    //continuous professional development
    public function continuousProfessionalDevelopments()
    {
        return $this->hasMany(ContinuousProfessionalDevelopment::class);
    }



}
