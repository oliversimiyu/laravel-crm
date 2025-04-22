<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Customer;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CommunicationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Communication::query()
            ->with(['communicatable'])
            ->when($request->search, function ($query, $search) {
                $query->where('subject', 'like', "%{$search}%");
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            });

        $communications = $query->latest('scheduled_at')->paginate(10);
        
        // Define types and statuses for filtering
        $types = ['email', 'call', 'meeting', 'note'];
        $statuses = ['planned', 'completed', 'cancelled'];
        
        return view('communications.index', compact('communications', 'types', 'statuses'));
    }

    public function create(): View
    {
        $customers = Customer::all();
        $leads = Lead::all();
        return view('communications.create', compact('customers', 'leads'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:email,call,meeting,note',
            'subject' => 'required|max:255',
            'content' => 'required',
            'communicatable_type' => 'required|in:App\Models\Customer,App\Models\Lead',
            'communicatable_id' => 'required|integer',
            'scheduled_at' => 'required|date',
            'status' => 'required|in:planned,completed,cancelled',
            'notes' => 'nullable|max:1000'
        ]);

        Communication::create($validated);

        return redirect()->route('communications.index')
            ->with('success', 'Communication created successfully.');
    }

    public function show(Communication $communication): View
    {
        return view('communications.show', compact('communication'));
    }

    public function edit(Communication $communication): View
    {
        $customers = Customer::all();
        $leads = Lead::all();
        return view('communications.edit', compact('communication', 'customers', 'leads'));
    }

    public function update(Request $request, Communication $communication): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:email,call,meeting,note',
            'subject' => 'required|max:255',
            'content' => 'required',
            'communicatable_type' => 'required|in:App\Models\Customer,App\Models\Lead',
            'communicatable_id' => 'required|integer',
            'scheduled_at' => 'required|date',
            'status' => 'required|in:planned,completed,cancelled',
            'notes' => 'nullable|max:1000'
        ]);

        $communication->update($validated);

        return redirect()->route('communications.index')
            ->with('success', 'Communication updated successfully.');
    }

    public function destroy(Communication $communication): RedirectResponse
    {
        $communication->delete();

        return redirect()->route('communications.index')
            ->with('success', 'Communication deleted successfully.');
    }
}
