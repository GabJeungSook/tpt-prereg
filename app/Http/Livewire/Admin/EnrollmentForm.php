<?php

namespace App\Http\Livewire\Admin;

use DB;
use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use WireUi\Traits\Actions;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Models\EnrollmentForm as EnrollmentFormModel;

class EnrollmentForm extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use Actions;

    protected function getTableQuery(): Builder
    {
        return EnrollmentFormModel::query();
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('create')
            ->label('Upload CEF')
            ->button()
            ->color('primary')
            ->icon('heroicon-o-plus')
            ->action(function (array $data): void {
                $count = EnrollmentFormModel::count();
                if($count > 0)
                {
                    $this->dialog()->error(
                        $title = 'Operation Failed',
                        $description = 'There is an existing file already.'
                    );
                }else{
                    DB::beginTransaction();
                    EnrollmentFormModel::create([
                        'file_name' => $data['file_path'],
                        'file_path' => $data['file_path'],
                     ]);
                    DB::commit();

                    $this->dialog()->success(
                        $title = 'Success',
                        $description = 'File was successfully saved'
                    );
                }

            })
            ->form([
                Forms\Components\FileUpload::make('file_path')
                ->directory('enrollment-forms')->preserveFilenames()
                ->label('Conformation of Enrollment Form')->required(),
            ])
        ];
    }

    public function getFileUrl($filename)
    {
        return Storage::url($filename);
    }

    public function getTableActions()
    {
        return [
            Action::make('edit')
            ->label('Update File')
            ->icon('heroicon-o-pencil')
            ->button()
            ->color('success')
            ->form([
                Forms\Components\FileUpload::make('file_path')
                ->directory('enrollment-forms')->preserveFilenames()
                ->label('Conformation of Enrollment Form')->required(),
            ])
            ->action(function (EnrollmentFormModel $record, array $data): void {
                DB::beginTransaction();
                $record->file_name = $data['file_path'];
                $record->file_path = $data['file_path'];
                $record->save();
                DB::commit();
                $this->dialog()->success(
                    $title = 'Success',
                    $description = 'File was successfully updated'
                );
            }),
            Action::make('download')
            ->label('Download')
            ->icon('heroicon-o-download')
            ->button()
            ->color('warning')
            ->url(fn (EnrollmentFormModel $record) => $this->getFileUrl($record->file_path))
            ->openUrlInNewTab()
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('file_path')->label('File Path'),
        ];
    }


    public function render()
    {
        return view('livewire.admin.enrollment-form');
    }
}
