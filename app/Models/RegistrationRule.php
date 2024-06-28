<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationRule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function register()
    {
        return $this->belongsTo(Register::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function qualificationCategory()
    {
        return $this->belongsTo(QualificationCategory::class);
    }

    public function feeItem()
    {
        return $this->belongsTo(FeeItem::class);
    }

    //has many  qualification
    public function professionalQualifications()
    {
        return $this->hasMany(ProfessionalQualification::class);
    }



}
