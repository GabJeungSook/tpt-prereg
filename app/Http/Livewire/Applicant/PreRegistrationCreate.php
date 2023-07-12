<?php

namespace App\Http\Livewire\Applicant;

use DB;
use Filament\Forms;
use App\Models\Campus;
use App\Models\Program;
use App\Models\EnrollmentForm;
use Livewire\Component;
use App\Models\Applicant;
use App\Models\ApplicantInfo;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\FileUpload;
use Carbon\Carbon;

class PreRegistrationCreate extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use Actions;

    public $record;
    public $step = 1;
    public $campus_id;
    public $course_id;
    public $attachment;
    public $cef;

    // for step 1
    public $first_name;
    public $middle_name;
    public $last_name;
    public $birthplace;
    public $birthday;
    public $age;
    public $present_address;
    public $permanent_address;
    public $contact_number;
    public $gender;
    public $religion;
    public $tribe;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\FileUpload::make('attachment')
                ->directory('application-forms')->preserveFilenames()
                ->label('Conformation of Enrollment Form (CEF)')->required(),
        ];
    }

    public function getFileUrl($filename)
    {
        return Storage::url($filename);
    }

    public function downloadCEF()
    {
        $filePath = storage_path('app/public/'.$this->cef->file_path);
        $fileName = 'SKSU_CEF.docx';

        return response()->download($filePath, $fileName);
    }

    public function updatedCampusId()
    {
        $this->course_id = null;
    }

    public function nextStep()
    {
        if($this->step === 1 && $this->record->applicant_info === null)
        {
            $this->validateCurrentStep();
        }elseif($this->step === 2 && $this->record->program_id === null)
        {
            $this->validateCurrentStep();
        }

        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function updatedBirthday()
    {
        $this->age = Carbon::parse($this->birthday)->diffInYears();
    }

    private function validateCurrentStep()
    {
        if($this->step === 1)
        {
            $this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'birthplace' => 'required',
                'birthday' => 'required',
                'present_address' => 'required',
                'permanent_address' => 'required',
                'contact_number' => 'required',
                'gender' => 'required',
                'religion' => 'required',
                'tribe' => 'required',
            ],[
                'first_name.required' => 'Please enter your first name',
                'last_name.required' => 'Please enter your last name',
                'birthplace.required' => 'Please enter your place of birth',
                'birthday.required' => 'Please enter your date of birth',
                'present_address.required' => 'Please enter your present address',
                'permanent_address.required' => 'Please enter your premanent address',
                'contact_number.required' => 'Please enter your contact number',
                'gender.required' => 'Please select your gender',
                'religion.required' => 'Please enter your religion',
                'tribe.required' => 'Please enter your tribe'
            ]);

            if($this->record->applicant_info === null)
            {
                $this->dialog()->error(
                    $title = 'Operation Failed',
                    $description = 'You have to save your information to proceed'
                );
                $this->step--;

            }

        }
        if ($this->step === 2) {
            $this->validate([
                'campus_id' => 'required',
                'course_id' => 'required',
            ],[
                'campus_id.required' => 'Please select a campus',
                'course_id.required' => 'Please select a course'
            ]);

            if($this->record->program_id === null)
            {
                $this->dialog()->error(
                    $title = 'Operation Failed',
                    $description = 'You have to save your selected course to proceed'
                );
                $this->step--;

            }
        }
    }

    public function logOut()
    {
        return Redirect::to('/');
    }

    public function save_info()
    {
        DB::beginTransaction();
        ApplicantInfo::create([
            'applicant_id' => $this->record->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'birthplace' => $this->birthplace,
            'birthday' => $this->birthday,
            'present_address' => $this->present_address,
            'permanent_address' => $this->permanent_address,
            'contact_number' => $this->contact_number,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'tribe' => $this->tribe,
        ]);
        DB::commit();
        $this->dialog()->success(
            $title = 'Success',
            $description = 'Data was successfully saved'
        );
        $this->step++;
    }

    public function save_course()
    {

        if($this->campus_id == null || $this->course_id == null)
        {
            $this->dialog()->error(
                $title = 'Operation Failed',
                $description = 'Please select a campus and a course'
            );
        }else{
            DB::beginTransaction();
            $this->record->program_id = $this->course_id;
            $this->record->save();
            DB::commit();
            $this->dialog()->success(
                $title = 'Success',
                $description = 'Data was successfully saved'
            );
            $this->step++;
        }
    }

    public function submitApplication()
    {
        if($this->attachment == null)
        {
            $this->dialog()->error(
                $title = 'Operation Failed',
                $description = 'Please upload the CEF file'
            );
        }elseif($this->record->program_id == null && $this->record->attachments() == null){
            $this->dialog()->error(
                $title = 'Operation Failed',
                $description = 'Please select a course and upload the CEF'
            );
        }else{
            foreach ($this->attachment as $file) {
                DB::beginTransaction();
                $this->record->attachments()->create(
                    [
                         "path"=>$file->storeAs('public',now()->format("HismdY-").$file->getClientOriginalName()),
                         "document_name"=>$file->getClientOriginalName(),
                    ]
                );

                $this->record->is_done = 1;
                $this->record->save();
                DB::commit();
            }
            // $this->dialog()->success(
            //     $title = 'Success',
            //     $description = 'Data was successfully saved'
            // );
            return redirect()->route('applicant.pre-registration-success', $this->record);
        }
    }

    public function mount()
    {
        $this->cef = EnrollmentForm::first();
        $this->campus_id = $this->record->campus_id;
    }

    public function render()
    {
        $campuses = Campus::get();

        $program_selects = Program::when($this->campus_id, function ($query) {
            $query->where('campus_id', $this->campus_id);
        })
        ->get();

        return view('livewire.applicant.pre-registration-create', [
            'campuses' => $campuses,
            'campus_name' => Campus::where('id', $this->campus_id)->first()?->name,
            'courses' =>$program_selects,
            'course_name' => Program::where('id', $this->course_id)->first()?->name,
        ]);
    }
}
