<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Qualification extends Model
{

    use HasSlug;
    protected $guarded = [];

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function accreditedInstitutions()
    {
        return $this->hasMany(AccreditedInstitution::class);
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
