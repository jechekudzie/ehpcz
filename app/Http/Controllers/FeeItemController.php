<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use App\Models\FeeItem;
use App\Models\PractitionerProfession;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class FeeItemController extends Controller
{
    //
    public function index(FeeCategory $feeCategory)
    {
        $feeItems = $feeCategory->feeItems;
        return view('administration.fee_items.index', compact('feeItems', 'feeCategory'));
    }

    public function store(Request $request,FeeCategory $feeCategory)
    {
        // Validate the request data
        $request->validate([
            'currency_id' => 'nullable|exists:currencies,id',
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'profession_id' => 'nullable|exists:professions,id',
        ]);

        // Check if a profession is set
        if (!empty($request->profession_id)) {
            // Create a FeeItem with 0.00 amount
            $feeItem =  $feeCategory->feeItems()->create([
                'currency_id' => $request->currency_id,
                'name' => $request->name,
                'amount' => 0.00, // Set amount to 0.00
                'description' => $request->description,
            ]);

            // Attach the fee item to the profession with the specified amount
            $profession = Profession::find($request->profession_id);
            $profession->fees()->attach($feeItem->id, ['amount' => $request->amount]);
        } else {
            // If no profession is set, just create a FeeItem with the specified amount
            $feeCategory->feeItems()->create([
                'currency_id' => $request->currency_id,
                'name' => $request->name,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
        }

        // Redirect back or to another page with a success message
        return redirect()->route('fees-categories.items',$feeCategory->slug)->with('success', 'Fee item created successfully.');
    }


    public function update(Request $request, FeeCategory $feeCategory, FeeItem $feeItem)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'currency_id' => 'nullable|exists:currencies,id',
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'profession_id' => 'nullable|exists:professions,id',
        ]);

        if (!empty($validatedData['profession_id'])) {
            // If a profession is set, update the FeeItem with amount set to 0.00
            $feeItem->update([
                'currency_id' => $validatedData['currency_id'],
                'name' => $validatedData['name'],
                // Set amount to 0.00 as in the store method
                'amount' => 0.00,
                'description' => $validatedData['description'],
            ]);

            // Sync the fee item to the profession with the specified amount
            $feeItem->professions()->sync([$validatedData['profession_id'] => ['amount' => $validatedData['amount']]]);
        } else {
            // If no profession is set, update the FeeItem normally and detach any existing professions
            if($feeItem->professions()->exists()){
                $feeItem->professions()->detach();
            }
            $feeItem->update([
                'currency_id' => $validatedData['currency_id'],
                'name' => $validatedData['name'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
            ]);
        }

        // Redirect back or to another page with a success message
        return redirect()->route('fees-categories.items',$feeCategory->slug)->with('success', 'Fee item updated successfully.');
    }

// Fetch fee items based on category
    public function getFeeItemsByCategory($categoryId)
    {
        $feeItems = FeeItem::where('fee_category_id', $categoryId)->with('professions')->get();
        return response()->json($feeItems);
    }

    // In FeeItemController
    public function getFeeItemAmount($id)
    {
        $feeItem = FeeItem::findOrFail($id);
        $practitionerProfessionId = request('practitionerProfessionId'); // Get practitionerProfessionId from query parameter

        $practitionerProfession = PractitionerProfession::find($practitionerProfessionId);

        $amount = null;

        if ($feeItem->amount == 0) {
            if ($feeItem->professions->isNotEmpty()) {
                $toAmount = $feeItem->professions->where('profession_id', $practitionerProfession->profesion_id)->first();
                $amount = $toAmount->pivot->amount ?? $feeItem->amount;
            }
        }else{
            $amount = $feeItem->amount;
        }

        return response()->json([
            'amount' => $amount,
        ]);
    }

    //destroy
    public function destroy(FeeCategory $feeCategory, FeeItem $feeItem)
    {
        $feeItem->delete();
        return redirect()->route('fees-categories.items',$feeCategory->slug)->with('success', 'Fee item deleted successfully.');
    }

}
