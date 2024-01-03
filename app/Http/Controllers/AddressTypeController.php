<?php

namespace App\Http\Controllers;

use App\Models\AddressType;
use Illuminate\Http\Request;

class AddressTypeController extends Controller
{
    public function index()
    {
        $addressTypes = AddressType::all();
        return view('administration.contact.addressTypes.index', compact('addressTypes'));

    }

    public function create()
    {
        return view('administration.contact.addressTypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        AddressType::create($request->all());

        return redirect()->route('address-types.index')
            ->with('success', 'Address type created successfully.');
    }

    public function show(AddressType $addressType)
    {
        return view('administration.contact.addressTypes.show', compact('addressType'));
    }

    public function edit(AddressType $addressType)
    {
        $addressTypes = AddressType::all();
        return view('administration.contact.addressTypes.edit', compact('addressType','addressTypes'));
    }

    public function update(Request $request, AddressType $addressType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $addressType->update($request->all());

        return redirect()->route('address-types.index')
            ->with('success', 'Address type updated successfully.');
    }

    public function destroy(AddressType $addressType)
    {
        $addressType->delete();

        return redirect()->route('address-types.index')
            ->with('success', 'Address type deleted successfully.');
    }
}
