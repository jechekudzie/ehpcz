<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ProfessionalQualification;
use App\Models\RegistrationApproval;
use Illuminate\Http\Request;

class RegistrationApprovalController extends Controller
{


    public function checkForPaymentApproval(Payment $payment)
    {
        if ($payment->professionalQualifications()->exists()) {
            $qualification = $payment->professionalQualifications->first();

            return redirect()->route('qualifications.approve.create', $qualification->slug);
        }else{

        }

    }

    //create approval
    public function create(ProfessionalQualification $professionalQualification)
    {
        $qualification = $professionalQualification;
        $practitioner = $professionalQualification->practitionerProfession->practitioner;

        //auth check
        if (auth()->check()) {
            $role = auth()->user()->roles->first()->name;
        } else {
            $role = null;
            redirect()->route('login');
        }


        return view('practitioners.approvals.registration_approval', compact('qualification', 'role', 'practitioner'));
    }

    public function approveByAdmin(Request $request, ProfessionalQualification $professionalQualification)
    {
        $this->storeApproval($request, $professionalQualification, 'admin', 'approved_by_admin');
        return redirect()->route('qualifications.approve.create', $professionalQualification->slug)->with('success', 'Qualification approved by Admin.');
    }

    public function approveByAccountant(Request $request, ProfessionalQualification $professionalQualification)
    {
        $this->storeApproval($request, $professionalQualification, 'accounts', 'approved_by_accounts');
        return redirect()->route('qualifications.approve.create', $professionalQualification->slug)->with('success', 'Qualification approved by Accounts.');
    }

    public function approveByRegistrar(Request $request, ProfessionalQualification $professionalQualification)
    {
        $this->storeApproval($request, $professionalQualification, 'registrar', 'approved_by_registrar');
        return redirect()->route('qualifications.approve.create', $professionalQualification->slug)->with('success', 'Qualification approved by Registrar.');
    }

    public function approveBySuperAdmin(Request $request, ProfessionalQualification $professionalQualification)
    {
        $this->storeApproval($request, $professionalQualification, 'super-admin', $request->status);
        return redirect()->route('qualifications.approve.create', $professionalQualification->slug)->with('success', 'Qualification approved by Super-Admin.');
    }

    private function storeApproval(Request $request, ProfessionalQualification $professionalQualification, $role, $status)
    {
        $qualification = $professionalQualification;
        $registrationApproval = new RegistrationApproval();
        $registrationApproval->professional_qualification_id = $qualification->id;
        $registrationApproval->user_id = auth()->id();
        $registrationApproval->role = $role;
        $registrationApproval->status = $request->status;
        $registrationApproval->comments = $request->comments;
        $registrationApproval->save();

        $qualification->status = $status;
        $qualification->save();
    }
}
