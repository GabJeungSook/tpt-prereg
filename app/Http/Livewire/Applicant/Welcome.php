<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;

class Welcome extends Component
{
    public $examinee_number;

    public function render()
    {
        return view('livewire.applicant.welcome');
    }

    public function checkExamineeNumber()
    {
        dd($this->examinee_number);
    }
}
