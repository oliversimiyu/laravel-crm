<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lead::query()
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
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            });

        $leads = $query->paginate(10);
        $companies = Company::all();

        return view('leads.index', compact('leads', 'companies'));
    }

    public function create(): View
    {
        $companies = Company::all();
        return view('leads.create', compact('companies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'position' => 'required|max:255',
            'email' => 'required|email|max:255|unique:leads',
            'phone' => 'nullable|max:20',
            'source' => 'required|max:255',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:new,contacted,qualified,proposal,negotiation,closed_won,closed_lost',
            'notes' => 'nullable|max:1000'
        ]);

        Lead::create($validated);

        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead): View
    {
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead): View
    {
        $companies = Company::all();
        return view('leads.edit', compact('lead', 'companies'));
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'position' => 'required|max:255',
            'email' => 'required|email|max:255|unique:leads,email,' . $lead->id,
            'phone' => 'nullable|max:20',
            'source' => 'required|max:255',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:new,contacted,qualified,proposal,negotiation,closed_won,closed_lost',
            'notes' => 'nullable|max:1000'
        ]);

        $lead->update($validated);

        return redirect()->route('leads.index')
            ->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }
}
