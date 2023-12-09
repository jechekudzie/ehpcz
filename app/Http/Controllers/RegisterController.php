<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $registers = Register::all();
        return view('registers.index', compact('registers'));
    }

    public function create()
    {
        return view('registers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Register::create($request->all());

        return redirect()->route('registers.index')
            ->with('success', 'Register created successfully.');
    }

    public function show(Register $register)
    {
        return view('registers.show', compact('register'));
    }

    public function edit(Register $register)
    {
        return view('registers.edit', compact('register'));
    }

    public function update(Request $request, Register $register)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $register->update($request->all());

        return redirect()->route('registers.index')
            ->with('success', 'Register updated successfully.');
    }

    public function destroy(Register $register)
    {
        $register->delete();

        return redirect()->route('registers.index')
            ->with('success', 'Register deleted successfully.');
    }
}
