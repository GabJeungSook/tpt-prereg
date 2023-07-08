<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;

class PreRegistrationCreate extends Component
{
    public $record;
    public $step = 1;
    public $name;
    public $email;
    public $address;
    public $phone;

    public function nextStep()
    {
        $this->validateCurrentStep();

        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    private function validateCurrentStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'address' => 'required',
                'phone' => 'required',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.applicant.pre-registration-create');
    }
}
