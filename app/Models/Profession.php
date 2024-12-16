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

  

    public function electionGroups()
    {
        return $this->belongsToMany(ElectionGroup::class, 'election_group_professions', 'profession_id', 'group_id');
    }

    public function categories()
    {
        return $this->hasManyThrough(
            ProfessionCategory::class,
            ElectionGroupProfession::class,
            'profession_id', // Foreign key on election_group_professions table
            'group_id', // Foreign key on profession_categories table
            'id', // Local key on professions table
            'group_id' // Local key on election_group_professions table
        );
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
