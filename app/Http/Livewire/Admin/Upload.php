<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;
use App\Models\Applicant;
use WireUi\Traits\Actions;

class Upload extends Component
{
    use WithFileUploads;
    use Actions;

    public $applicants;
    public $applicants_isulan;

    public function uploadApplicants()
    {
        $csvContents = Storage::get($this->applicants->getClientOriginalName());
        $csvReader = Reader::createFromString($csvContents);
        $csvRecords = $csvReader->getRecords();

        foreach ($csvRecords as $csvRecord) {
            $examineeNumber = $csvRecord[0];

            // Check if the examinee number already exists in the database
            $existingApplicant = Applicant::where('examinee_number', $examineeNumber)->first();

            if (!$existingApplicant) {
                // Examinee number does not exist, create a new record
                Applicant::create([
                    'examinee_number' => $examineeNumber,
                    'name' => $csvRecord[1],
                    'campus_id' => 3,
                ]);
            }else{
                $existingApplicant->update([
                    'campus_id' => 3,
                ]);
            }
        }

        $this->dialog()->success(
            $title = 'Success',
            $description = 'Data uploaded'
        );
    }

    public function uploadApplicantsIsulan()
    {
        $csvContents = Storage::get($this->applicants_isulan->getClientOriginalName());
        $csvReader = Reader::createFromString($csvContents);
        $csvRecords = $csvReader->getRecords();

        foreach ($csvRecords as $csvRecord) {
            $examineeNumber = $csvRecord[0];

            // Check if the examinee number already exists in the database
            $existingApplicant = Applicant::where('examinee_number', $examineeNumber)->first();

            if (!$existingApplicant) {
                // Examinee number does not exist, create a new record
                Applicant::create([
                    'examinee_number' => $examineeNumber,
                    'name' => $csvRecord[1],
                    'campus_id' => 2,
                ]);
            }else{
                $existingApplicant->update([
                    'campus_id' => 2,
                ]);
            }
        }

        $this->dialog()->success(
            $title = 'Success',
            $description = 'Data uploaded'
        );
    }


    public function render()
    {
        return view('livewire.admin.upload');
    }
}
