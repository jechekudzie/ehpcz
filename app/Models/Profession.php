<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Profession extends Model
{

    use HasSlug;
    protected $guarded = [];

    public function practitionerProfessions()
    {
        return $this->hasMany(PractitionerProfession::class);
    }
    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function fees() {
        return $this->belongsToMany(FeeItem::class, 'profession_fees')
            ->withPivot(['amount']);
    }

    //renewals
    public function renewals()
    {
        return $this->hasMany(Renewal::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
