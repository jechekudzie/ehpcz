<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Country extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    public function practitioners()
    {
        return $this->hasMany(Practitioner::class);
    }

    public function registrationRules()
    {
        return $this->hasMany(RegistrationRule::class);
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
