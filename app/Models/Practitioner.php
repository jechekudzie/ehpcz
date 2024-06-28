<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Practitioner extends Model
{

    use HasSlug;

    protected $guarded = [];

    // Practitioners associated with this user
    public function practitioners() {
        return $this->belongsToMany(User::class, 'practitioner_user', 'user_id', 'practitioner_id');
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function employments()
    {
        return $this->hasMany(Employment::class);
    }

    //create employment
    public function createEmployment($employment)
    {
        return $this->employments()->create($employment);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    //create contact
    public function createContact($contact)
    {
        return $this->contacts()->create($contact);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    //create address
    public function createAddress($address)
    {
        return $this->addresses()->create($address);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    //add employment statusphp
    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class);
    }

    //has practitioner identification
    public function practitionerIdentifications()
    {
        return $this->hasMany(PractitionerIdentification::class);
    }

    public function createPractitionerIdentifications($practitionerIdentification)
    {
        return $this->practitionerIdentifications()->create($practitionerIdentification);
    }

    //practitioner professions
    public function practitionerProfessions()
    {
        return $this->hasMany(PractitionerProfession::class);
    }

    //create practitioner profession
    public function createPractitionerProfession($practitionerProfession)
    {
        return $this->practitionerProfessions()->create($practitionerProfession);
    }

    //renewals
    public function renewals()
    {
        return $this->hasMany(Renewal::class);
    }

    //practitioner user pivot table
    public function users()
    {
        return $this->belongsToMany(User::class, 'practitioner_user');
    }

    //payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    //continuous professional development
    public function continuousProfessionalDevelopments()
    {
        return $this->hasMany(ContinuousProfessionalDevelopment::class);
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
