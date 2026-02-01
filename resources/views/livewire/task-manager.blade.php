<div class="max-w-4xl mx-auto p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">My Tasks</h2>
        
        <div class="flex bg-gray-100 p-1 rounded-lg shadow-inner">
            @foreach(['all', 'pending', 'completed'] as $f)
                <button wire:click="$set('filter', '{{ $f }}')" 
                    class="px-4 py-1.5 text-xs font-bold uppercase rounded-md transition-all {{ $filter == $f ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    {{ $f }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="mb-8 rounded-xl shadow-sm border-2 transition-all duration-300 {{ $isEditMode ? 'border-orange-300 bg-orange-50/50' : 'border-gray-100 bg-white' }}">
        <form wire:submit.prevent="{{ $isEditMode ? 'updateTask' : 'createTask' }}" class="p-6 space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] {{ $isEditMode ? 'text-orange-600' : 'text-gray-400' }}">
                    {{ $isEditMode ? 'Editing Task' : 'New Activity' }}
                </span>
                @if($isEditMode)
                    <button type="button" wire:click="cancelEdit" class="text-xs font-bold text-gray-500 hover:text-red-500 uppercase">Cancel</button>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" wire:model="title" placeholder="Task title..." class="border-gray-200 rounded-lg focus:ring-indigo-500">
                <select wire:model="priority" class="border-gray-200 rounded-lg focus:ring-indigo-500">
                    <option value="low">Low Priority</option>
                    <option value="medium">Medium Priority</option>
                    <option value="high">High Priority</option>
                </select>
            </div>

            <textarea wire:model="description" placeholder="Optional description..." class="w-full border-gray-200 rounded-lg focus:ring-indigo-500" rows="2"></textarea>

            <div class="flex flex-col md:flex-row gap-4 items-center">
                <input type="date" wire:model="due_date" class="w-full md:w-1/2 border-gray-200 rounded-lg">
                <button type="submit" class="w-full md:w-1/2 py-2.5 rounded-lg font-black uppercase text-xs tracking-widest text-white transition-all {{ $isEditMode ? 'bg-orange-500 hover:bg-orange-600' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                    {{ $isEditMode ? 'Save Changes' : 'Create Task' }}
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-3">
        @forelse($tasks as $task)
            <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-sm border-l-4 {{ $task->priority == 'high' ? 'border-red-500' : ($task->priority == 'medium' ? 'border-yellow-400' : 'border-green-400') }}">
                <div class="flex items-center space-x-4">
                    <input type="checkbox" wire:click="toggleComplete({{ $task->id }})" {{ $task->is_completed ? 'checked' : '' }} class="h-5 w-5 rounded text-indigo-600 cursor-pointer">
                    
                    <div wire:click="showDetails({{ $task->id }})" class="cursor-pointer">
                        <p class="text-sm font-bold {{ $task->is_completed ? 'line-through text-gray-300' : 'text-gray-800' }}">
                            {{ $task->title }}
                        </p>
                        <span class="text-[9px] font-bold text-gray-400">Priority: {{ $task->priority }} @if($task->due_date) | Due: {{ $task->due_date->format('d M') }} @endif</span>
                    </div>
                </div>

                <div class="flex items-center space-x-1">
                    <button wire:click="editTask({{ $task->id }})" class="p-2 text-gray-300 hover:text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete task?" class="p-2 text-gray-300 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400 italic">No tasks found.</div>
        @endforelse
    </div>

    @if($showingTask)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-8 shadow-2xl relative">
                <button wire:click="closeDetails" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">✕</button>
                
                <div class="flex items-center space-x-2 mb-4">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $showingTask->priority == 'high' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600' }}">
                        {{ $showingTask->priority }} Priority
                    </span>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $showingTask->title }}</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">{{ $showingTask->description ?? 'No description provided.' }}</p>
                
                <div class="border-t pt-4 flex justify-between text-sm text-gray-400">
                    <span>Due Date: {{ $showingTask->due_date ? $showingTask->due_date->format('d M, Y') : 'Not set' }}</span>
                    <span>Status: {{ $showingTask->is_completed ? 'Completed' : 'Pending' }}</span>
                </div>
            </div>
        </div>
    @endif
</div>