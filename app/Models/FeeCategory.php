<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FeeCategory extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    public function feeItems()
    {
        return $this->hasMany(FeeItem::class);
    }

    //has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
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
