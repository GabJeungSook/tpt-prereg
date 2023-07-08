<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\Applicant;
use WireUi\Traits\Actions;


class Welcome extends Component
{
    use Actions;
    public $examinee_number;

    public function render()
    {
        return view('livewire.applicant.welcome');
    }

    public function checkExamineeNumber()
    {
        $applicant = Applicant::where('examinee_number', $this->examinee_number)->first();
        if(!$applicant)
        {
            $this->examinee_number = null;
            $this->dialog()->error(
                $title = 'Not Found',
                $description = 'Examinee number doesn\'t exist'
            );
        }else{
            return redirect()->route('applicant.pre-registration', $applicant);
            // dd($applicant);
        }
    }
}
