<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Applicant;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard',
        [
            'finished_applications' => Applicant::where('is_done', 1)->count(),
            'total_applications' => Applicant::count(),
        ]);
    }
}
