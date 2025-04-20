<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Sale::query()
            ->with(['customer'])
            ->when($request->search, function ($query, $search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            })
            ->when($request->company_id, function ($query, $company_id) {
                $query->whereHas('customer', function ($query) use ($company_id) {
                    $query->where('company_id', $company_id);
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            });

        $sales = $query->latest('date')->paginate(10);
        $companies = Company::all();
        
        return view('sales.index', compact('sales', 'companies'));
    }

    public function create(): View
    {
        $customers = Customer::all();
        return view('sales.create', compact('customers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:sales|max:255',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'required|in:pending,paid,cancelled',
            'payment_method' => 'required|max:255',
            'notes' => 'nullable|max:1000'
        ]);

        Sale::create($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale): View
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale): View
    {
        $customers = Customer::all();
        return view('sales.edit', compact('sale', 'customers'));
    }

    public function update(Request $request, Sale $sale): RedirectResponse
    {
        $validated = $request->validate([
            'invoice_number' => 'required|max:255|unique:sales,invoice_number,' . $sale->id,
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'required|in:pending,paid,cancelled',
            'payment_method' => 'required|max:255',
            'notes' => 'nullable|max:1000'
        ]);

        $sale->update($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
