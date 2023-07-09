<?php

namespace App\Http\Livewire\Admin;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use DB;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Applicant as ApplicantModel;
use App\Models\EnrollmentForm;
use WireUi\Traits\Actions;

class Applicant extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use Actions;

    protected function getTableQuery(): Builder
    {
        return ApplicantModel::query();
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('create')
            ->label('Add New Applicant')
            ->button()
            ->color('primary')
            ->icon('heroicon-o-plus')
            ->action(function (array $data): void {
                    DB::beginTransaction();
                    ApplicantModel::create([
                        'examinee_number' => $data['examinee_number'],
                        'name' => $data['name'],
                     ]);
                    DB::commit();

                    $this->dialog()->success(
                        $title = 'Success',
                        $description = 'Applicant was successfully saved'
                    );


            })
            ->form([
                Forms\Components\TextInput::make('examinee_number')->required()->numeric(),
                Forms\Components\TextInput::make('name')->required()
            ])
        ];
    }

    public function getTableActions()
    {
        return [
            Action::make('download')
            ->label('Download CEF')
            ->icon('heroicon-o-download')
            ->button()
            ->color('warning')
            ->visible(fn ($record) => $record->is_done)
            ->action(function ($record) {
                $enrollment_form = EnrollmentForm::first();
                $filePath = storage_path('app/public/'.$enrollment_form->file_path);
                $fileName = strtoupper($record->name).'_SKSU_CEF.docx';
                return response()->download($filePath, $fileName);
            }),
            ActionGroup::make([
                Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->button()
                ->color('success')
                ->mountUsing(fn (Forms\ComponentContainer $form, ApplicantModel $record) => $form->fill([
                    'examinee_number' => $record->examinee_number,
                    'name' => $record->name,
                ]))
                ->form([
                    Forms\Components\TextInput::make('examinee_number')->required()->numeric(),
                    Forms\Components\TextInput::make('name')->required()
                ])
                ->action(function (ApplicantModel $record, array $data): void {
                    DB::beginTransaction();
                    $record->examinee_number = $data['examinee_number'];
                    $record->name = $data['name'];
                    $record->save();
                    DB::commit();
                    $this->dialog()->success(
                        $title = 'Success',
                        $description = 'Applicant was successfully updated'
                    );
                }),
                Tables\Actions\ViewAction::make()
                ->color('primary')
                ->mountUsing(fn (Forms\ComponentContainer $form, ApplicantModel $record) => $form->fill([
                    'examinee_number' => $record->examinee_number,
                    'name'  => $record->name,
                    'campus'  => $record->program?->campus->name,
                    'course'  => $record->program?->name,
                ]))->form([
                    Forms\Components\TextInput::make('examinee_number')->label('Examinee Number'),
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\TextInput::make('campus')
                    ->formatStateUsing(fn ($record) => $record->program_id != null ? $record->program?->campus->name : 'NOT YET SELECTED'),
                    Forms\Components\TextInput::make('course')
                    ->formatStateUsing(fn ($record) => $record->program_id != null ? $record->program?->name : 'NOT YET SELECTED'),
                ]),
                ])
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('examinee_number')->searchable(),
            Tables\Columns\TextColumn::make('name')
            ->formatStateUsing(fn (ApplicantModel $record) => strtoupper($record->name))
            ->searchable(),
            Tables\Columns\BadgeColumn::make('is_done')
            ->label('Applied')
            ->enum([
                0 => 'No',
                1 => 'Yes',
            ])
            ->colors([
                'danger' => 0,
                'success' => 1,
            ])
            ->searchable(),
            Tables\Columns\TextColumn::make('name')
        ];
    }

    public function render()
    {
        return view('livewire.admin.applicant');
    }
}
