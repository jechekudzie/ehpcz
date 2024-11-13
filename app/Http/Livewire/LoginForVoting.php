<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Practitioner;
use Illuminate\Support\Facades\Session;

class LoginForVoting extends Component
{
    public $registrationNumber;
    public $idNumber;
    public $mobileNumber;
    public $errorMessage;

    protected $listeners = ['showModal' => 'showLoginModal'];

    public function showLoginModal()
    {
        $this->reset(['registrationNumber', 'idNumber', 'mobileNumber', 'errorMessage']);
        $this->dispatchBrowserEvent('show-login-modal');
    }

    public function authenticate()
    {
        $this->validate([
            'registrationNumber' => 'required',
            'idNumber' => 'required',
            'mobileNumber' => 'required',
        ]);

        $practitioner = Practitioner::where('registration_number', $this->registrationNumber)->first();

        if (!$practitioner) {
            $this->errorMessage = 'Registration number not found.';
            return;
        }

        $practitioner->update([
            'id_number' => $this->idNumber,
            'mobile_number' => $this->mobileNumber,
        ]);

        Session::put('practitioner_id', $practitioner->id);

        // Emit to CandidateListing component to refresh or update
        $this->emitTo('candidate-listing', 'candidateAdded');
        $this->dispatchBrowserEvent('hide-login-modal');
    }

    public function render()
    {
        return view('livewire.login-for-voting');
    }
}
