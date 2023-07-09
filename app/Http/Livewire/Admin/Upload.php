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

    public function uploadApplicants(){

        $csvContents = Storage::get($this->applicants->getClientOriginalName());
        $csvReader = Reader::createFromString($csvContents);
        $csvRecords = $csvReader->getRecords();

        foreach ($csvRecords as $csvRecord) {
            Applicant::create([
               'examinee_number' => $csvRecord[0],
               'name' => $csvRecord[1],
            ]);
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
