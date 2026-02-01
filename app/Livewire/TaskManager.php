<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{
    // Properties for creating a task
    public $title, $description, $priority = 'medium', $due_date;
    
    // Property for filtering tasks
    public $filter = 'all'; 

    public $isEditMode = false;
    public $editingTaskId;

    public $showingTask = null;

    protected $rules = [
        'title' => 'required|min:3',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date',
    ];

    public function createTask()
    {
        $this->validate();

        Task::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'is_completed' => false,
        ]);

        $this->reset(['title', 'description', 'priority', 'due_date']);
        session()->flash('message', 'Task created successfully.');
    }

    public function toggleComplete($taskId)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($taskId);
        $task->update(['is_completed' => !$task->is_completed]);
    }
    public function editTask($taskId)
{
    $task = Task::where('user_id', Auth::id())->findOrFail($taskId);
    
    $this->editingTaskId = $task->id;
    $this->title = $task->title;
    $this->description = $task->description;
    $this->priority = $task->priority;
    $this->due_date = $task->due_date;
    
    $this->isEditMode = true; // Ativa o modo de edição
}

public function updateTask()
{
    $this->validate();

    $task = Task::where('user_id', Auth::id())->findOrFail($this->editingTaskId);
    $task->update([
        'title' => $this->title,
        'description' => $this->description,
        'priority' => $this->priority,
        'due_date' => $this->due_date,
    ]);

    $this->cancelEdit(); // Limpa tudo e volta ao modo normal
}


public function showDetails($taskId)
{
    $this->showingTask = Task::where('user_id', Auth::id())->findOrFail($taskId);
}

public function closeDetails()
{
    $this->showingTask = null;
}

public function cancelEdit()
{
    $this->reset(['title', 'description', 'priority', 'due_date', 'isEditMode', 'editingTaskId']);
}
    public function deleteTask($taskId)
    {
        Task::where('user_id', Auth::id())->findOrFail($taskId)->delete();
    }

    public function render()
    {
        // Get tasks for the authenticated user
        $query = Auth::user()->tasks();

        // Apply filters based on the briefing requirements
        if ($this->filter === 'pending') {
            $query->where('is_completed', false);
        } elseif ($this->filter === 'completed') {
            $query->where('is_completed', true);
        }

        return view('livewire.task-manager', [
            'tasks' => $query->orderBy('due_date', 'asc')->orderBy('priority', 'desc')->get()
            
        ]);
    }
}