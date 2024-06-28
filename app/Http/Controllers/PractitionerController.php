<?php

namespace App\Http\Controllers;

use App\Models\AddressType;
use App\Models\ContactType;
use App\Models\Country;
use App\Models\EmploymentStatus;
use App\Models\Gender;
use App\Models\IdentificationType;
use App\Models\Practitioner;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PractitionerController extends Controller
{
    //create an index method to get all practitioner and pass practitioner to the view
    public function index()
    {
        $practitioners = Practitioner::all();
        $countries = Country::all();
        $titles = Title::all();
        $genders = Gender::all();
        $employmentStatuses = EmploymentStatus::all();

        return view('practitioners.personal_information.index', compact('practitioners', 'countries',
            'genders', 'titles', 'employmentStatuses'));
    }

    //add create method
    public function create()
    {
        return view('practitioners.personal_information.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title_id' => 'required|exists:titles,id',
            'gender_id' => 'required|exists:genders,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'employment_status_id' => 'nullable|exists:employment_statuses,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Create a new practitioner without the image
        $validatedDataWithoutImage = Arr::except($validatedData, ['image']);
        $practitioner = Practitioner::create($validatedDataWithoutImage);

        // Initialize imageName variable
        $imageName = null;
        $path = null;

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the image to the desired directory within the public folder
            $directoryPath = public_path('images/practitioners/profiles');
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }
            $path = $image->move($directoryPath, $imageName);

            // Update the image path in the practitioner record
            $relativePath = 'images/practitioners/profiles/' . $imageName;
            $practitioner->image = $relativePath;
            $practitioner->save();
        }

        // Redirect to a specific route (e.g., index page of practitioners)
        return redirect()->route('practitioners.show',$practitioner->slug)->with('success', 'Practitioner added successfully.');
    }

    //add show method
    public function show(Practitioner $practitioner)
    {
        //initialize identificationErrors variable
        $identificationErrors = null;

        $countries = Country::all();
        $titles = Title::all();
        $genders = Gender::all();
        $employmentStatuses = EmploymentStatus::all();
        $identificationTypes = IdentificationType::all();
        $contactTypes = ContactType::all();
        $addressTypes = AddressType::all();
        return view('practitioners.personal_information.show', compact('practitioner','countries',
        'titles','genders','employmentStatuses','identificationTypes','contactTypes','addressTypes','identificationErrors'));
    }

    //add edit method
    public function edit(Practitioner $practitioner)
    {
        return view('practitioners.personal_information.edit', compact('practitioner'));
    }

   // add an update method
    public function update(Request $request,Practitioner $practitioner)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title_id' => 'required|exists:titles,id',
            'gender_id' => 'required|exists:genders,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'employment_status_id' => 'nullable|exists:employment_statuses,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'practitionerErrors')
                ->withInput();
        }

        $validatedData = $validator->validated();

        // Create a new practitioner without the image
        $validatedDataWithoutImage = Arr::except($validatedData, ['image']);


        $practitioner->update($validatedDataWithoutImage);

        // Initialize imageName variable
        $imageName = null;
        $path = null;

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the image to the desired directory within the public folder
            $directoryPath = public_path('images/practitioners/profiles');
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }
            $path = $image->move($directoryPath, $imageName);

            // Update the image path in the practitioner record
            $relativePath = 'images/practitioners/profiles/' . $imageName;
            $practitioner->image = $relativePath;
            $practitioner->save();
        }

        // Redirect to a specific route (e.g., index page of practitioners)
        return redirect()->route('practitioners.show',$practitioner->slug)->with('success', 'Practitioner updated successfully.');
    }

}
