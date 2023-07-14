<?php

namespace App\Http\Livewire\Admin;

use DB;
use Filament\Forms;
use Filament\Tables;
use App\Models\Campus;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\EnrollmentForm;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Applicant as ApplicantModel;

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
                        'campus_id' => $data['campus_id'],
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
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('campus_id')->label('Campus')->options(Campus::all()->pluck('name', 'id'))->required()
            ])
        ];
    }

    public function downloadAttachment($attachmentId)
    {
        $attachment = $this->applicant->attachments()->find($attachmentId);
        if ($attachment) {
            $path = $attachment->path;
            $documentName = $attachment->document_name;
            return Storage::download($path, $documentName);
        }
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
                $attachment = $record->attachments()->where('documentable_id', $record->id)->first();
                if ($attachment) {
                    $path = $attachment->path;
                    $documentName = $attachment->document_name;
                    return Storage::download($path, $documentName);
                }
            }),
            Action::make('delete_cef')
            ->label('Remove CEF')
            ->icon('heroicon-o-trash')
            ->button()
            ->color('danger')
            ->visible(fn ($record) => $record->is_done)
            ->action(function ($record){
                DB::beginTransaction();
                $record->attachments->first()->delete();
                $record->is_done = 0;
                $record->save();
                DB::commit();
                $this->dialog()->success(
                    $title = 'Success',
                    $description = 'CEF was successfully removed'
                );
            })->requiresConfirmation(),
            ActionGroup::make([
                Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->button()
                ->color('success')
                ->mountUsing(fn (Forms\ComponentContainer $form, ApplicantModel $record) => $form->fill([
                    'examinee_number' => $record->examinee_number,
                    'name' => $record->name,
                    'campus_id' => $record->campus_id,
                ]))
                ->form([
                    Forms\Components\TextInput::make('examinee_number')->required()->numeric(),
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\Select::make('campus_id')->label('Campus')->options(Campus::all()->pluck('name', 'id'))->required()
                ])
                ->action(function (ApplicantModel $record, array $data): void {
                    DB::beginTransaction();
                    $record->examinee_number = $data['examinee_number'];
                    $record->name = $data['name'];
                    $record->campus_id = $data['campus_id'];
                    $record->save();
                    DB::commit();
                    $this->dialog()->success(
                        $title = 'Success',
                        $description = 'Applicant was successfully updated'
                    );
                })->visible(fn ($record) => $record->is_done === 0),
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
                    ->formatStateUsing(fn ($record) => $record->campus_id != null ? $record->campus->name : 'NOT YET SELECTED'),
                    Forms\Components\TextInput::make('course')
                    ->formatStateUsing(fn ($record) => $record->program_id != null ? $record->program?->name : 'NOT YET SELECTED'),
                ]),
                ])
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('examinee_number')->label('Examinee Number')->searchable(),
            Tables\Columns\TextColumn::make('campus.name')->label('Campus')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('name')
            ->formatStateUsing(fn (ApplicantModel $record) => strtoupper($record->name))
            ->searchable()->sortable(),
            Tables\Columns\BadgeColumn::make('is_done')
            ->sortable()
            ->label('Applied')
            ->enum([
                0 => 'No',
                1 => 'Yes',
            ])
            ->colors([
                'danger' => 0,
                'success' => 1,
            ])
            ->searchable()
        ];
    }

    public function render()
    {
        return view('livewire.admin.applicant');
    }
}
