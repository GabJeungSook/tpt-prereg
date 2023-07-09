<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;

class PreRegistrationCreate extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    public $record;
    public $step = 1;
    public $campus_id;
    public $course_id;

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('attachment')->required(),
        ];
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        $this->step++;
    }

    public function logOut()
    {
        return Redirect::to('/');
    }

    public function prevStep()
    {
        $this->step--;
    }

    private function validateCurrentStep()
    {
        if ($this->step === 2) {
            $this->validate([
                'campus_id' => 'required',
                'course_id' => 'required',
            ],[
                'campus_id.required' => 'Please select a campus',
                'course_id.required' => 'Please select a course'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.applicant.pre-registration-create');
    }
}
