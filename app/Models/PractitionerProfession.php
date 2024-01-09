<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PractitionerProfession extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    //professionalQualifications
    public function professionalQualifications()
    {
        return $this->hasMany(ProfessionalQualification::class);
    }

    //create professional qualification
    public function createProfessionalQualification($data)
    {
        return $this->professionalQualifications()->create($data);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['practitioner_id', 'profession_id'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
