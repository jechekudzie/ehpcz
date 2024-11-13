<?php

namespace App\Http\Controllers;

use App\Models\PractitionerData;
use App\Models\ProfessionalQualification;
use App\Models\Title;
use Illuminate\Http\Request;
use App\Models\IdentificationType;
use App\Models\Profession;
use App\Models\Qualification;
use App\Models\Institution;
use App\Models\EmploymentSector;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\Province;

class PractitionerDataController extends Controller
{

    public function index()
    {
        $practitioners = PractitionerData::all();

        return view('administration.import.practitioner_data', compact('practitioners'));
    }
    public function create()
    {
        $identificationTypes = IdentificationType::all();
        $professions = Profession::all();
        $qualifications = Qualification::all();
        $institutions = Institution::all();
        $employmentSectors = EmploymentSector::all();
        $genders = Gender::all();
        $maritalStatuses = MaritalStatus::all();
        $provinces = Province::all();
        $titles = Title::all();

        return view('practitioners.data.create', compact(
            'identificationTypes',
            'professions',
            'qualifications',
            'institutions',
            'employmentSectors',
            'genders',
            'maritalStatuses',
            'provinces','titles'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'identification_number' => 'required|string|max:255',
            'identification_type_id' => 'required|integer|exists:identification_types,id',
            'profession_id' => 'required|integer|exists:professions,id',
            'qualification_id' => 'required|integer|exists:qualifications,id',
            'registration_number' => 'required|string|max:255',
            'institution_id' => 'required|integer|exists:institutions,id',
            'registration_year' => 'required|integer|min:1900|max:' . date('Y'),
            'employment_status' => 'required|in:employed,unemployed',
            'current_employer' => 'nullable|string|max:255',
            'employment_sector_id' => 'required|integer|exists:employment_sectors,id',
            'province_id' => 'required|integer|exists:provinces,id',
            'email' => 'required|email|unique:practitioner_data,email',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'date_of_birth' => 'required',
            'gender_id' => 'required|integer|exists:genders,id',
            'marital_status_id' => 'required|integer|exists:marital_statuses,id',
            'title_id' => 'required|integer|exists:titles,id',
        ]);

        PractitionerData::create($request->all());

        return redirect()->route('portal.index')->with('success', 'Practitioner data has been added successfully.
        The Council will notify you with your login credentials.');
    }
}
