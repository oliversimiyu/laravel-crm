<?php

namespace App\Livewire;

use App\Models\Activity;
use Livewire\Component;
use Livewire\WithPagination;

class RecentActivities extends Component
{
    use WithPagination;
    
    // Polling interval in milliseconds (5 seconds)
    public $pollingInterval = 5000;
    
    // For dashboard we still only show 3
    public $isDashboard = false;
    public $perPage = 10;
    
    protected $listeners = ['refresh' => '$refresh'];
    
    public function mount($isDashboard = false)
    {
        $this->isDashboard = $isDashboard;
    }
    
    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }
    
    public function render()
    {
        if ($this->isDashboard) {
            // For dashboard, just get 3 latest activities
            $activities = Activity::with(['user', 'loggable'])
                ->latest()
                ->take(3)
                ->get();
        } else {
            // For activities page, use pagination
            $activities = Activity::with(['user', 'loggable'])
                ->latest()
                ->paginate($this->perPage);
        }
        
        return view('livewire.recent-activities', [
            'activities' => $activities
        ]);
    }
}
