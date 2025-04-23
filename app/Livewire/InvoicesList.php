<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoicesList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $status = '';
    public $customer_id = '';
    public $perPage = 10;
    
    // Polling interval in milliseconds (10 seconds)
    public $pollingInterval = 10000;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'customer_id' => ['except' => ''],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatus()
    {
        $this->resetPage();
    }
    
    public function updatingCustomerId()
    {
        $this->resetPage();
    }
    
    public function paginationView()
    {
        return 'vendor.pagination.tailwind';
    }
    
    public function render()
    {
        $query = Invoice::query()
            ->with('customer')
            ->when($this->search, function($query) {
                $query->where('invoice_number', 'like', "%{$this->search}%")
                    ->orWhereHas('customer', function($q) {
                        $q->where('first_name', 'like', "%{$this->search}%")
                          ->orWhere('last_name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%");
                    });
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->when($this->customer_id, function($query) {
                $query->where('customer_id', $this->customer_id);
            });
            
        $invoices = $query->latest()->paginate($this->perPage);
        $customers = Customer::orderBy('first_name')->get();
        
        return view('livewire.invoices-list', [
            'invoices' => $invoices,
            'customers' => $customers,
        ]);
    }
}
