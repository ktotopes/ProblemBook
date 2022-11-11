<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Task;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class TaskTable extends DataTableComponent
{
    protected $model = Task::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPerPageAccepted([3]);
        $this->setPerPageVisibilityDisabled();
        $this->setColumnSelectDisabled();
        $this->setPerPage(3);
    }

    public function changeStatus($id)
    {
        $task = Task::query()->where('id', '=', $id)->first();
        $task->status = !$task->status;
        $task->save();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable()->searchable(),
            Column::make("E-mail", "email")
                ->sortable()->searchable(),
            Column::make("Text", "body")
                ->searchable()->format(fn($value, $row, Column $column) => mb_strimwidth($row->body, 0, 30, '...')),
            LinkColumn::make('Action')
                ->title(fn($row) => 'Edit')
                ->location(fn($row) => route('task.edit', $row->id)),
            BooleanColumn::make("Status", "status")
                ->sortable(),
            LinkColumn::make('ChangeStatus')
                ->title(fn($row) => 'ChangeStatus')
                ->location(fn($row) => '#')
                ->attributes(function ($row) {
                    return [
                        'wire:click' => "changeStatus('$row->id')",
                    ];
                }),
        ];
    }
}
