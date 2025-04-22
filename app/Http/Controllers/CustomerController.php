<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Company;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index(Request $request): View
    {
        $query = Customer::query()
            ->with('company')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->company_id, function ($query, $company_id) {
                $query->where('company_id', $company_id);
            });

        $customers = $query->paginate(10);
        $companies = Company::all();

        return view('customers.index', compact('customers', 'companies'));
    }

    public function create(): View
    {
        $companies = Company::all();
        return view('customers.create', compact('companies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'position' => 'required|max:255',
            'email' => 'required|email|max:255|unique:customers',
            'phone' => 'nullable|max:20',
            'notes' => 'nullable|max:1000'
        ]);

        $customer = Customer::create($validated);

        // Log activity
        $this->activityService->log(
            'create',
            'Created customer ' . $customer->first_name . ' ' . $customer->last_name,
            $customer,
            'A new customer was added to the system'
        );

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    public function show(Customer $customer): View
    {
        $customer->load([
            'company',
            'leads' => function ($query) {
                $query->latest();
            },
            'communications' => function ($query) {
                $query->latest();
            },
            'tasks' => function ($query) {
                $query->latest();
            },
            'sales' => function ($query) {
                $query->latest();
            }
        ]);

        // Get statistics
        $customer->active_leads_count = $customer->leads()->where('status', 'active')->count();
        $customer->total_sales = $customer->sales()->sum('total');
        $customer->pending_tasks_count = $customer->tasks()->where('status', 'pending')->count();

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer): View
    {
        $companies = Company::all();
        return view('customers.edit', compact('customer', 'companies'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'position' => 'required|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|max:20',
            'notes' => 'nullable|max:1000'
        ]);

        $customer->update($validated);

        // Log activity
        $this->activityService->log(
            'update',
            'Updated customer ' . $customer->first_name . ' ' . $customer->last_name,
            $customer,
            'Customer information was updated'
        );

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        // Log activity before deletion
        $this->activityService->log(
            'delete',
            'Deleted customer ' . $customer->first_name . ' ' . $customer->last_name,
            $customer,
            'Customer was removed from the system'
        );

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}
