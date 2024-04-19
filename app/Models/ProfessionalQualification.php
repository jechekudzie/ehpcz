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

    //qualificationFiles
    public function qualificationFiles()
    {
        return $this->hasMany(QualificationFile::class);
    }

    //belongs to many registration rules
    public function registrationRule()
    {
        return $this->belongsTo(RegistrationRule::class);
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'professional_qualification_payment')
            ->withPivot(['renewal_period'])
            ->withTimestamps();
    }


    public function findMatchingRegistrationRuleId($practitionerProfession, $isZimbabwean, $qualificationCategoryId)
    {
        // Find potential registration rules based on initial criteria
        $potentialRegistrationRules = RegistrationRule::with('feeItem.professions')
            ->where('is_zimbabwean', $isZimbabwean)
            ->where('qualification_category_id', $qualificationCategoryId)
            ->get();

        foreach ($potentialRegistrationRules as $rule) {
            $feeItemProfessions = $rule->feeItem->professions; // Accessing the professions related to the feeItem

            if ($feeItemProfessions->isEmpty()) {
                // If there are no professions linked to this feeItem, the rule is a match
                return $rule;
            } else {
                // If there are linked professions, check if any match the practitioner's profession
                foreach ($feeItemProfessions as $profession) {
                    if ($profession->id === $practitionerProfession->profession_id) {
                        // Found a matching profession, return this rule's ID
                        return $rule;
                    }
                }
            }
        }

        // No matching rule was found
        return null;
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
