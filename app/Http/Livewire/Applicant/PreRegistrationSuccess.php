<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class PreRegistrationSuccess extends Component
{
    public $record;

    public function logOut()
    {
        return Redirect::to('/');
    }

    public function render()
    {
        return view('livewire.applicant.pre-registration-success');
    }
}
