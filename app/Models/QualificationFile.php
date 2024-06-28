<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;

class QualificationFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    //professionalQualification
    public function professionalQualification()
    {
        return $this->belongsTo(ProfessionalQualification::class);
    }

    //requirement
    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['professional_qualification_id','requirement_id'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
