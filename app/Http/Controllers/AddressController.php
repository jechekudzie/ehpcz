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
    public function store(Request $request,Practitioner $practitioner)
    {
        $validator = Validator::make($request->all(), [

            'address_type_id' => [
                'required',
                Rule::unique('addresses')->where(function ($query) use ($practitioner) {
                    return $query->where('practitioner_id', $practitioner->id);
                })
            ],
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

        $practitioner->createAddress($validatedData);

        return redirect()->route('practitioners.show', $practitioner->slug)
            ->with('address_success', 'Address created successfully.');
    }
}
