<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class EditTask extends Component
{
    public ?Task $task = null;
    public $body;

    protected array $rules = [
        'body' => 'required|string',
    ];

    public function update()
    {
        $this->validate();

        $this->task->update([
            'body' => $this->body,
        ]);

        return to_route('task.index');
    }

    public function mount()
    {
        $this->body = $this->task->body;
    }

    public function render()
    {
        return view('livewire.edit-task');
    }

}
