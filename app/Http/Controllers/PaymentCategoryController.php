<?php

namespace App\Http\Controllers;

use App\Models\PaymentCategory;
use Illuminate\Http\Request;

class PaymentCategoryController extends Controller
{
    public function index()
    {
        $paymentCategories = PaymentCategory::all();
        return view('payment_categories.index', compact('paymentCategories'));
    }

    public function create()
    {
        return view('payment_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:payment_categories',
            // Add validation rules for other payment category fields here
        ]);

        PaymentCategory::create($request->all());

        return redirect()->route('payment-categories.index')
            ->with('success', 'Payment Category created successfully.');
    }

    public function show(PaymentCategory $paymentCategory)
    {
        return view('payment_categories.show', compact('paymentCategory'));
    }

    public function edit(PaymentCategory $paymentCategory)
    {
        return view('payment_categories.edit', compact('paymentCategory'));
    }

    public function update(Request $request, PaymentCategory $paymentCategory)
    {
        $request->validate([
            'name' => 'required|unique:payment_categories,name,' . $paymentCategory->id,
            // Add validation rules for other payment category fields here
        ]);

        $paymentCategory->update($request->all());

        return redirect()->route('payment-categories.index')
            ->with('success', 'Payment Category updated successfully.');
    }

    public function destroy(PaymentCategory $paymentCategory)
    {
        $paymentCategory->delete();

        return redirect()->route('payment-categories.index')
            ->with('success', 'Payment Category deleted successfully.');
    }
}
