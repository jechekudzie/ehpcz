<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\Employment;
use App\Models\EmploymentSector;
use App\Models\EmploymentStatus;
use App\Models\Gender;
use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use App\Models\Profession;
use App\Models\ProfessionalQualification;
use App\Models\Province;
use App\Models\Qualification;
use App\Models\Requirement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataImport2 implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        ini_set('max_execution_time', 300); // 300 seconds = 5 minutes
        //
        foreach ($rows as $row) {

            $practitioner = Practitioner::create(
                [
                    'first_name' => $row[0],
                    'last_name' => $row[1],
                    'country_id' => 230,

                ]);


            $profession = Profession::where('name', $row[4])->first();

            if ($profession != null) {
                $practitionerProfession = PractitionerProfession::create([
                    'practitioner_id' => $practitioner->id,
                    'profession_id' => $profession->id,
                    'registration_number' => $row[2],
                    'is_verified' => 1,
                    'is_active' => 1,
                ]);

                if (!empty($row[5])) {
                    $qualification = Qualification::where('name', 'like', '%' . $row[5] . '%')->first();
                    if ($qualification != null) {
                        $professionalQualification = ProfessionalQualification::create([
                            'practitioner_profession_id' => $practitionerProfession->id,
                            'qualification_id' => $qualification->id ?? null,
                            'qualification_category_id' => 1,
                            'qualification_name' => $row[5],
                            'institution_name' => $row[6],
                            'is_verified' => 1,
                            'is_active' => 1,
                        ]);

                        // Update registration rule and other related fields
                        $isZimbabwean = $practitionerProfession->practitioner->country->name == 'Zimbabwe' ? 1 : 0;

                        $registrationRule = $professionalQualification->findMatchingRegistrationRuleId($practitionerProfession, $isZimbabwean, $professionalQualification->qualification_category_id);
                        $professionalQualification->registration_rule_id = $registrationRule->id;
                        $professionalQualification->register_id = $registrationRule->register_id;
                        $professionalQualification->save();

                        //requirements
                        $requirements = Requirement::whereNotIn('id', [1, 2, 3])->get();

                        $professionalQualification->qualificationFiles()->createMany($requirements->map(function ($requirement) {
                            return [
                                'requirement_id' => $requirement->id,
                                'file' => null
                            ];
                        })->toArray());
                        foreach ($requirements as $requirement) {
                            $professionalQualification->qualificationFiles()->updateOrCreate(
                                ['requirement_id' => $requirement->id],
                                ['file' => null] // Assuming no new file data provided
                            );
                        }
                    }
                }
            }
        }
    }
}
