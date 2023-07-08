<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Filament\Tables;
use App\Models\Applicant as ApplicantModel;
use Illuminate\Database\Eloquent\Builder;

class Applicant extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return ApplicantModel::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('examinee_number')->searchable(),
            Tables\Columns\TextColumn::make('name')->searchable(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.applicant');
    }
}
