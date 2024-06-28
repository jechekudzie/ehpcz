<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use Illuminate\Http\Request;

class RenewalController extends Controller
{
    //
    public function index(Practitioner $practitioner)
    {
        return view('practitioners.renewals.index', compact('practitioner'));
    }

    //store
    public function store(Practitioner $practitioner, Request $request)
    {
        $request->validate([

            'period' => 'required',
            'practitioner_profession_id' => 'required|exists:practitioner_professions,id',
        ]);

        // Find the practitioner profession
        $practitionerProfession = PractitionerProfession::find($request->practitioner_profession_id);

        // Determine the start and end dates based on the profession's expiry month
        // Use the 'period' from the request for the 'start_date' year
        $start_date = $request->period . '-' . $practitionerProfession->profession->expiry_month . '-30';

        // Calculate 'end_date' by adding one year to the 'period'
        $end_year = $request->period + 1;
        $end_date = $end_year . '-' . $practitionerProfession->profession->expiry_month . '-30';

        // Use updateOrCreate to either update an existing renewal or create a new one
        $renewal = $practitionerProfession->renewals()->updateOrCreate(
            [
                'period' =>  $request->period,
                'practitioner_id' => $practitionerProfession->practitioner_id,
                'practitioner_profession_id' => $practitionerProfession->id,
            ],
            [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'profession_id' => $practitionerProfession->profession_id,
                'renewal_status_id' => 0, // Assuming 0 is the default status for new renewals
                'cpd' => 0, // Assuming CPD is not completed by default
            ]
        );

        // Check if the renewal was newly created or updated
        if ($renewal->wasRecentlyCreated) {
            // Actions to take if a new renewal was created
            return back()->with('success', 'New renewal created successfully.');
        } else {
            // Actions to take if an existing renewal was updated
            return back()->with('success', 'Existing renewal updated successfully.');
        }
    }
}
