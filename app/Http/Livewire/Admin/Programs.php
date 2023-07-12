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
use App\Models\Program as ProgramModel;


class Programs extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use Actions;

    protected function getTableQuery(): Builder
    {
        return ProgramModel::query();
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('create')
            ->label('Add New Program')
            ->button()
            ->color('primary')
            ->icon('heroicon-o-plus')
            ->action(function (array $data): void {
                    DB::beginTransaction();
                    ProgramModel::create([
                        'campus_id' => $data['campus_id'],
                        'name' => $data['name'],
                     ]);
                    DB::commit();

                    $this->dialog()->success(
                        $title = 'Success',
                        $description = 'Program was successfully saved'
                    );


            })
            ->form([
                Forms\Components\Select::make('campus_id')->label('Campus')->options(Campus::all()->pluck('name', 'id'))->required(),
                Forms\Components\TextInput::make('name')->required(),
            ])
        ];
    }

    public function getTableActions()
    {
        return [
            Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->button()
                ->color('success')
                ->mountUsing(fn (Forms\ComponentContainer $form, ProgramModel $record) => $form->fill([
                    'campus_id' => $record->campus_id,
                    'name' => $record->name,
                ]))
                ->form([
                    Forms\Components\Select::make('campus_id')->label('Campus')->options(Campus::all()->pluck('name', 'id'))->required(),
                    Forms\Components\TextInput::make('name')->required(),
                ])
                ->action(function (ProgramModel $record, array $data): void {
                    DB::beginTransaction();
                    $record->campus_id = $data['campus_id'];
                    $record->name = $data['name'];
                    $record->save();
                    DB::commit();
                    $this->dialog()->success(
                        $title = 'Success',
                        $description = 'Program was successfully updated'
                    );
                }),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('campus.name')
            ->formatStateUsing(fn (ProgramModel $record) => strtoupper($record->campus->name))
            ->searchable(),
            Tables\Columns\TextColumn::make('name')
            ->label('Name')
            ->searchable()
        ];
    }

    public function render()
    {
        return view('livewire.admin.programs');
    }
}
