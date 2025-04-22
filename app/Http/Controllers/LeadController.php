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
        
        // Define statuses and sources for filtering
        $statuses = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'closed_won', 'closed_lost'];
        $sources = ['website', 'referral', 'social_media', 'email_campaign', 'cold_call', 'event', 'other'];

        return view('leads.index', compact('leads', 'companies', 'statuses', 'sources'));
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

    /**
     * Convert a lead to a customer.
     *
     * @param Request $request
     * @param Lead $lead
     * @return RedirectResponse
     */
    public function convert(Request $request, Lead $lead): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'notes' => 'nullable|string|max:1000',
            'keep_lead' => 'nullable|boolean',
        ]);

        // Create a new customer from the lead data
        $customer = \App\Models\Customer::create([
            'first_name' => $lead->first_name,
            'last_name' => $lead->last_name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'position' => $lead->position,
            'company_id' => $lead->company_id,
            'notes' => $lead->notes . "\n\nConversion Notes: " . $request->notes,
        ]);

        // Log the activity
        if (app()->bound('App\Services\ActivityService')) {
            $activityService = app()->make('App\Services\ActivityService');
            $activityService->log(
                'convert',
                'Converted lead to customer: ' . $lead->first_name . ' ' . $lead->last_name,
                $customer,
                'Lead #' . $lead->id . ' converted to Customer #' . $customer->id,
                ['lead_id' => $lead->id]
            );
        }

        // Delete the lead if not keeping it
        if (!$request->has('keep_lead')) {
            $lead->delete();
        } else {
            // Mark the lead as converted
            $lead->update(['status' => 'closed_won']);
        }

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Lead successfully converted to customer.');
    }
}
