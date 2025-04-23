<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\Sale;
use Livewire\Component;

class RevenueCounter extends Component
{
    public $revenue;
    
    // Polling interval in milliseconds (10 seconds)
    public $pollingInterval = 10000;
    
    public function mount()
    {
        $this->calculateRevenue();
    }
    
    public function calculateRevenue()
    {
        // Calculate total revenue from paid invoices
        $invoiceRevenue = Invoice::where('status', 'paid')->sum('total');
        
        // Calculate total revenue from sales
        $salesRevenue = Sale::sum('amount');
        
        // Total revenue
        $this->revenue = $invoiceRevenue + $salesRevenue;
    }
    
    public function render()
    {
        return view('livewire.revenue-counter');
    }
}
