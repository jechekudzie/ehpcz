<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Practitioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    //
    public function index()
    {
        $addresses = Address::all();
        return view('addresses.index', compact('addresses'));
    }

    //add store method
    public function store(Request $request, Practitioner $practitioner)
    {
        $validator = Validator::make($request->all(), [
            'address_type_id' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'addressErrors')
                ->withInput();
        }

        $validatedData = $validator->validated();

        // Check if an address with the given address_type_id exists for this practitioner
        $address = $practitioner->addresses()->where('address_type_id', $validatedData['address_type_id'])->first();

        if ($address) {
            // If the address exists, update it
            $address->update($validatedData);
            $message = 'Address updated successfully.';
        } else {
            // If the address doesn't exist, create a new one
            $practitioner->createAddress($validatedData);
            $message = 'Address created successfully.';
        }

        return redirect()->route('practitioners.show', $practitioner->slug)
            ->with('address_success', $message);
    }

}
