<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class AccreditedInstitution extends Model
{
    use HasSlug;
    protected $guarded = [];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
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
