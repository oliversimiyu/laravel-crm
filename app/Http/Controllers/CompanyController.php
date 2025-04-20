<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'industry' => 'required|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|max:500',
            'notes' => 'nullable|max:1000'
        ]);

        Company::create($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company): View
    {
        $company->loadCount([
            'customers',
            'leads as active_leads_count' => function ($query) {
                $query->where('status', 'active');
            }
        ]);

        return view('companies.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'industry' => 'required|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|max:500',
            'notes' => 'nullable|max:1000'
        ]);

        $company->update($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}
