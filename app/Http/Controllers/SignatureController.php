<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureController extends Controller
{

    public function index()
    {
        $signatures = Signature::all();
        return view('administration.signatures.index', compact('signatures'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        //upload file
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imagePath = '/signatories/signatures'; // The directory where you want to save the files
            $imageName = time() . '_' . $image->getClientOriginalName(); // Customizing the file name to be unique
            $image->move(public_path($imagePath), $imageName); // Move the image to the specified directory

            // Set the image path in the validated data
            $validatedData['path'] = $imagePath . '/' . $imageName;
        }

        $signature = Signature::create($validatedData);

        return redirect()->route('admin.signatures.index')->with('success', 'Signature created successfully');
    }


    public function show(Signature $signature)
    {
        return response()->json($signature);
    }


    public function edit(Signature $signature)
    {
        //
    }


    public function update(Request $request, Signature $signature)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string|max:255',
        ]);

        $signature->update($request->all());

        return response()->json($signature);
    }

    //activate or deactivate signature
    public function toggleActivation(Signature $signature)
    {
        //toggle the is_active field
        if ($signature->is_active == 0) {
            $signature->update([
                'is_active' => 1
            ]);
        } else {
            $signature->update([
                'is_active' => 0
            ]);

        }

        $signature->save();

        return back()->with('success', 'Signature updated successfully');
    }


    public function destroy(Signature $signature)
    {
        $signature->delete();

        return response()->json(null, 204);
    }
}
