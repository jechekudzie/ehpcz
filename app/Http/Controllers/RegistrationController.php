<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use App\Models\ProfessionalQualification;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    //
    public function index(PractitionerProfession $practitionerProfession, ProfessionalQualification $professionalQualification,Practitioner $practitioner, Request $request)
    {

        $practitioner = $practitionerProfession->practitioner;
        $registrationRule = $professionalQualification->registrationRule;
        // Accessing the professions related to the feeItem
        $feeItemProfessions = $registrationRule->feeItem->professions;

        $amount = 0; // Default amount
        $currentFeeItem = $registrationRule->feeItem;

        if ($feeItemProfessions->isEmpty()) {
            // If there are no professions linked to this feeItem, use the feeItem's default amount
            $amount = $registrationRule->feeItem->amount; // Assuming there's a default_amount field
        } else {
            // If there are linked professions, check if any match the practitioner's profession
            foreach ($feeItemProfessions as $profession) {
                if ($profession->id === $practitionerProfession->profession_id) {
                    // Found a matching profession, use the amount from the pivot table
                    $amount = $profession->pivot->amount;
                    break; // Break the loop once a match is found
                }
            }
        }

        if ($practitionerProfession->renewals()->count() > 0) {
            //check if $practitionerProfession has renewals for this profession and current period (current year)
            $renewal = $practitionerProfession->renewals()->where('period', date('Y'))->first();
            if ($renewal) {

                return  redirect()->route('renewal.payments.index', $renewal->id);
            }
        } else {
            //create renewal
            //start date is $practitionerProfession->expiry_month if this year and end date is $practitionerProfession->expiry_month + 1 year

            $start_date = date('Y') . '-' . $practitionerProfession->profession->expiry_month . '-30';
            $end_date = date('Y', strtotime('+1 year')) . '-' . $practitionerProfession->profession->expiry_month . '-30';

            $practitionerProfession->renewals()->create([
                'period' => date('Y'),
                'start_date' => $start_date,
                'end_date' => $end_date,
                'practitioner_id' => $practitionerProfession->practitioner_id,
                'practitioner_profession_id' => $practitionerProfession->id,
                'profession_id' => $practitionerProfession->profession_id,
                'renewal_status_id' => 0,
                'cpd' => 0,
            ]);

            return  redirect()->route('renewals.index', $practitioner->slug);

            //return view('practitioners.payments.index', compact('practitionerProfession', 'currentFeeItem', 'professionalQualification'));
        }

    }
}
