<?php

namespace App\Http\Livewire\Applicant;

use DB;
use Filament\Forms;
use App\Models\Campus;
use App\Models\Program;
use App\Models\EnrollmentForm;
use Livewire\Component;
use App\Models\Applicant;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\FileUpload;

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
        $fileName = 'SKSU_CEF.pdf';

        return response()->download($filePath, $fileName);
    }

    public function updatedCampusId()
    {
        $this->course_id = null;
    }

    public function nextStep()
    {
        if($this->record->program_id === null)
        {
            $this->validateCurrentStep();
        }

        $this->step++;
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

            if($this->record->program_id === null)
            {
                $this->dialog()->error(
                    $title = 'Operation Failed',
                    $description = 'You have to save your selected campus and course to proceed'
                );
                $this->step--;

            }
        }
    }

    public function logOut()
    {
        return Redirect::to('/');
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
