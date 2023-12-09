<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    public function index()
    {
        $contactTypes = ContactType::all();
        return view('contactTypes.index', compact('contactTypes'));
    }

    public function create()
    {
        return view('contactTypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ContactType::create($request->all());

        return redirect()->route('contactTypes.index')
            ->with('success', 'Contact type created successfully.');
    }

    public function show(ContactType $contactType)
    {
        return view('contactTypes.show', compact('contactType'));
    }

    public function edit(ContactType $contactType)
    {
        return view('contactTypes.edit', compact('contactType'));
    }

    public function update(Request $request, ContactType $contactType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $contactType->update($request->all());

        return redirect()->route('contactTypes.index')
            ->with('success', 'Contact type updated successfully.');
    }

    public function destroy(ContactType $contactType)
    {
        $contactType->delete();

        return redirect()->route('contactTypes.index')
            ->with('success', 'Contact type deleted successfully.');
    }
}
