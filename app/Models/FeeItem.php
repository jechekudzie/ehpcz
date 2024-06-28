<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FeeItem extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function professions()
    {
        return $this->belongsToMany(Profession::class, 'profession_fees')
            ->withPivot(['amount']);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    //belongs to currency
    public function currency()
    {
        return $this->belongsTo(Currency::class);
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
