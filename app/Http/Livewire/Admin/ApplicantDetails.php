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
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Applicant;
use App\Models\ApplicantInfo;
use Filament\Forms\Components\Grid;

class ApplicantDetails extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use Actions;

    protected function getTableQuery(): Builder
    {
        return ApplicantInfo::query();
    }

    public function getTableActions()
    {
        return [
            ActionGroup::make([
                Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->button()
                ->color('success')
                ->mountUsing(fn (Forms\ComponentContainer $form, ApplicantInfo $record) => $form->fill([
                            'first_name' => $record->first_name,
                            'middle_name' => $record->middle_name,
                            'last_name' => $record->last_name,
                            'birthplace' => $record->birthplace,
                            'birthday' => $record->birthday,
                            'present_address' => $record->present_address,
                            'permanent_address' => $record->permanent_address,
                            'contact_number' => $record->contact_number,
                            'gender' => $record->gender,
                            'religion' => $record->religion,
                            'tribe' => $record->tribe,
                ]))
                ->form([
                    Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('first_name')->required(),
                            Forms\Components\TextInput::make('middle_name'),
                            Forms\Components\TextInput::make('last_name')->required(),
                            Forms\Components\TextInput::make('birthplace')->required(),
                            Forms\Components\DatePicker::make('birthday')->required(),
                            Forms\Components\TextInput::make('present_address')->required(),
                            Forms\Components\TextInput::make('permanent_address')->required(),
                            Forms\Components\TextInput::make('contact_number')->required()->numeric(),
                            Forms\Components\Select::make('gender')->required()
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ]),
                            Forms\Components\TextInput::make('religion')->required(),
                            Forms\Components\TextInput::make('tribe')->required(),
                        ])

                ])
                ->action(function (ApplicantInfo $record, array $data): void {
                    DB::beginTransaction();
                    $record->first_name = $data['first_name'];
                    $record->middle_name = $data['middle_name'];
                    $record->last_name = $data['last_name'];
                    $record->birthplace = $data['birthplace'];
                    $record->birthday = $data['birthday'];
                    $record->present_address = $data['present_address'];
                    $record->permanent_address = $data['permanent_address'];
                    $record->contact_number = $data['contact_number'];
                    $record->gender = $data['gender'];
                    $record->religion = $data['religion'];
                    $record->tribe = $data['tribe'];
                    $record->save();
                    DB::commit();
                    $this->dialog()->success(
                        $title = 'Success',
                        $description = 'Applicant was successfully updated'
                    );
                }),
                Action::make('remove_details')
                ->icon('heroicon-o-trash')
                ->button()
                ->color('danger')
                ->action(fn ($record) => $record->delete())
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->applicant->is_done === 0)
                ])
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('applicant.name')->label('Full Name')->searchable(),
            Tables\Columns\TextColumn::make('first_name')->label('First Name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('middle_name')->label('Middle Name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('last_name')->label('Last Name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('birthplace')->label('Birthplace')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('birthday')->date('F d, Y')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('present_address')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('permanent_address')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('contact_number')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('gender')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('religion')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('tribe')->searchable()->sortable(),
        ];
    }


    public function render()
    {
        return view('livewire.admin.applicant-details');
    }
}
