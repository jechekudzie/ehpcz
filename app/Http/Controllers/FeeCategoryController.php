<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use Illuminate\Http\Request;

class FeeCategoryController extends Controller
{
    //

    public function index()
    {
        $feeCategories = FeeCategory::all();
        return view('administration.fee_categories.index', compact('feeCategories'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        FeeCategory::create($request->all());
        return redirect()->route('fees-categories.index')->with('success', 'Fee Category created successfully.');
    }

    //update
    public function update(Request $request, FeeCategory $feeCategory)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $feeCategory->update($request->all());
        return redirect()->route('fees-categories.index')->with('success', 'Fee Category updated successfully.');
    }

    //destroy
    public function destroy(FeeCategory $feeCategory)
    {
        $feeCategory->delete();
        return redirect()->route('fees-categories.index')->with('success', 'Fee Category deleted successfully.');
    }


}
