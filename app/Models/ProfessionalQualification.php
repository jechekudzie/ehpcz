<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProfessionalQualification extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    //practitionerProfession
    public function practitionerProfession()
    {
        return $this->belongsTo(PractitionerProfession::class);
    }

    //qualificationCategory
    public function qualificationCategory()
    {
        return $this->belongsTo(QualificationCategory::class);
    }
    //qualificationLevel
    public function qualificationLevel()
    {
        return $this->belongsTo(QualificationLevel::class);
    }
    //register
    public function register()
    {
        return $this->belongsTo(Register::class);
    }
    //qualification
    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    //institution
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['practitioner_profession_id','qualification_category_id','qualification_level_id'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
