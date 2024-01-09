<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Employment extends Model
{
    use HasSlug;
    protected $guarded = [];

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    //province
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    //city
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    //employment sector
    public function employmentSector()
    {
        return $this->belongsTo(EmploymentSector::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('employer')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
