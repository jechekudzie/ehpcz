<?php

namespace App\Http\Controllers;

use App\Models\FeeItem;
use App\Models\RegistrationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegistrationRuleController extends Controller
{
    //index
    public function index()
    {
        $registrationRules = RegistrationRule::all();
        return view('administration.registration_rules.index',compact('registrationRules'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'register_id' => 'required|exists:registers,id',
            'is_zimbabwean' => 'required|boolean',
            'qualification_category_id' => 'required|exists:qualification_categories,id',
            'fee_item_id' => 'required|exists:fee_items,id',
        ]);

        // Create a new RegistrationRule
        $registrationRule = RegistrationRule::create($validatedData);

        // Redirect back or to another page with a success message
        return redirect()->route('registration-rules.index')->with('success', 'Registration rule created successfully.');
    }

    public function update(Request $request, $ruleId)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'register_id' => 'required|exists:registers,id',
            'is_zimbabwean' => 'required|boolean',
            'qualification_category_id' => 'required|exists:qualification_categories,id',
            'fee_item_id' => 'required|exists:fee_items,id',
        ]);

        // Find the existing RegistrationRule
        $registrationRule = RegistrationRule::findOrFail($ruleId);

        // Update the RegistrationRule with the validated data
        $registrationRule->update($validatedData);

        // Redirect back or to another page with a success message
        return redirect()->route('registration-rules.index')->with('success', 'Registration rule updated successfully.');
    }

    public function getFeeItem($id)
    {
        $registrationRule = RegistrationRule::with('feeItem')->findOrFail($id);

        return response()->json([
            'fee_item_id' => $registrationRule->feeItem->id,

        ]);
    }


}
