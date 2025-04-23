<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class TasksList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $status = '';
    public $priority = '';
    public $due_date = '';
    public $perPage = 10;
    
    // Polling interval in milliseconds (10 seconds)
    public $pollingInterval = 10000;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'priority' => ['except' => ''],
        'due_date' => ['except' => ''],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatus()
    {
        $this->resetPage();
    }
    
    public function updatingPriority()
    {
        $this->resetPage();
    }
    
    public function updatingDueDate()
    {
        $this->resetPage();
    }
    
    public function paginationView()
    {
        return 'vendor.pagination.tailwind';
    }
    
    public function render()
    {
        $query = Task::query()
            ->with(['user', 'taskable'])
            ->when($this->search, function($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->when($this->priority, function($query) {
                $query->where('priority', $this->priority);
            })
            ->when($this->due_date, function($query) {
                if ($this->due_date === 'today') {
                    $query->whereDate('due_date', today());
                } elseif ($this->due_date === 'tomorrow') {
                    $query->whereDate('due_date', today()->addDay());
                } elseif ($this->due_date === 'this_week') {
                    $query->whereBetween('due_date', [today(), today()->endOfWeek()]);
                } elseif ($this->due_date === 'overdue') {
                    $query->whereDate('due_date', '<', today())
                          ->where('status', '!=', 'completed');
                }
            });
            
        $tasks = $query->latest()->paginate($this->perPage);
        
        return view('livewire.tasks-list', [
            'tasks' => $tasks,
        ]);
    }
}
