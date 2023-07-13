<?php

namespace App\Http\Livewire\Admin;

use App\Models\Applicant;
use App\Models\Campus;
use App\Models\Program;
use Livewire\Component;

class Report extends Component
{
    public $report_get;
    public $selected_campus;
    public $selected_course;
    protected $students;

    public function updatedSelectedCampus()
    {
        if($this->selected_campus === null)
        {
            $this->selected_course = null;
        }
    }

    public function render()
    {
        $campuses = Campus::get();

        $program_selects = Program::when($this->selected_campus, function ($query) {
            $query->where('campus_id', $this->selected_campus);
        })
        ->get();

        $query = Applicant::where('is_done', 1);

        if ($this->selected_campus) {
            $query->whereHas('campus', function ($query) {
                $query->where('id', $this->selected_campus);
            });
        }

        if ($this->selected_course) {
            $query->whereHas('program', function ($query) {
                $query->where('id', $this->selected_course);
            });
        }

        $this->students = $query->get();

        return view('livewire.admin.report', [
            'campuses' => $campuses,
            'campus_name' => Campus::where('id', $this->selected_campus)->first()?->name,
            'course_name' => Program::where('id', $this->selected_course)->first()?->name,
            'courses' => $program_selects,
            'applied_students' => $this->report_get != 1 ? [] : ($this->students == null ? [] : $this->students),
        ]);
    }
}
