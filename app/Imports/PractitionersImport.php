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
use PhpParser\Node\Expr\CallLike;

class PractitionersImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        ini_set('max_execution_time', 20000);

        foreach ($rows as $row) {
            // Skip rows with empty critical fields
            if (empty($row[0]) && empty($row[1]) && empty($row[3])) {
                continue;
            }
            $practitioner = Practitioner::create(
                [
                    'last_name' => $row[0],
                    'first_name' => $row[1],
                    'country_id' => 230,
                ]);


            $profession = Profession::where('name', $row[3])->first();

            if ($profession != null) {
                $practitionerProfession = PractitionerProfession::create([
                    'practitioner_id' => $practitioner->id,
                    'profession_id' => $profession->id,
                    'registration_number' => $row[2],
                    'is_verified' => 1,
                    'is_active' => 1,
                ]);

                if (!empty($row[4])) {
                    $qualification = Qualification::where('name', 'like', '%' . $row[4] . '%')->first();
                    if ($qualification != null) {
                        $professionalQualification = ProfessionalQualification::create([
                            'practitioner_profession_id' => $practitionerProfession->id,
                            'qualification_id' => $qualification->id ?? null,
                            'qualification_category_id' => 1,
                            'qualification_name' => $row[4],
                            'institution_name' => null,
                            'is_verified' => 1,
                            'is_active' => 1,
                            'status' => 'approved',
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

            //generate renewal periods
            if ($practitionerProfession->profession->expiry_month > 06) {
                $renewal = $practitionerProfession->renewals()->updateOrCreate(
                    [
                        'period' => 2023,
                        'practitioner_id' => $practitionerProfession->practitioner_id,
                        'practitioner_profession_id' => $practitionerProfession->id,
                        'profession_id' => $practitionerProfession->profession_id,
                    ],
                    [
                        'start_date' => 2023 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'end_date' => 2024 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'renewal_status_id' => 1,
                        'status' => 'approved',
                        'cpd' => 0,
                    ]
                );
            } elseif ($practitionerProfession->profession->expiry_month == 06) {
                $renewal1 = $practitionerProfession->renewals()->updateOrCreate(
                    [
                        'period' => 2023,
                        'practitioner_id' => $practitionerProfession->practitioner_id,
                        'practitioner_profession_id' => $practitionerProfession->id,
                        'profession_id' => $practitionerProfession->profession_id,
                    ],
                    [
                        'start_date' => 2023 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'end_date' => 2024 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'renewal_status_id' => 1,
                        'status' => 'approved',
                        'cpd' => 0,
                    ]
                );

                $renewal2 = $practitionerProfession->renewals()->updateOrCreate(
                    [
                        'period' => 2024,
                        'practitioner_id' => $practitionerProfession->practitioner_id,
                        'practitioner_profession_id' => $practitionerProfession->id,
                        'profession_id' => $practitionerProfession->profession_id,
                    ],
                    [
                        'start_date' => 2024 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'end_date' => 2025 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'renewal_status_id' => 1,
                        'status' => 'approved',
                        'cpd' => 0,
                    ]
                );
            } else {
                $renewal = $practitionerProfession->renewals()->updateOrCreate(
                    [
                        'period' => 2024,
                        'practitioner_id' => $practitionerProfession->practitioner_id,
                        'practitioner_profession_id' => $practitionerProfession->id,
                        'profession_id' => $practitionerProfession->profession_id,
                    ],
                    [
                        'start_date' => 2024 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'end_date' => 2025 . '-' . $practitionerProfession->profession->expiry_month . '-30',
                        'renewal_status_id' => 1,
                        'status' => 'approved',
                        'cpd' => 0,
                    ]
                );
            }


        }
    }

}
