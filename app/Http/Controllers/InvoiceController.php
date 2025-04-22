<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('customer')->latest();
        
        // Apply filters
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $invoices = $query->paginate(10);
        $customers = Customer::orderBy('first_name')->get();
        
        return view('invoices.index', compact('invoices', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('first_name')->get();
        $invoice_number = Invoice::generateInvoiceNumber();
        
        return view('invoices.create', compact('customers', 'invoice_number'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:invoices',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Create invoice
            $invoice = new Invoice();
            $invoice->customer_id = $request->customer_id;
            $invoice->invoice_number = $request->invoice_number;
            $invoice->issue_date = $request->issue_date;
            $invoice->due_date = $request->due_date;
            $invoice->tax_rate = $request->tax_rate ?? 0;
            $invoice->discount_amount = $request->discount_amount ?? 0;
            $invoice->notes = $request->notes;
            $invoice->status = 'draft';
            $invoice->subtotal = 0; // Will be calculated
            $invoice->tax_amount = 0; // Will be calculated
            $invoice->total = 0; // Will be calculated
            $invoice->save();
            
            // Add invoice items
            $subtotal = 0;
            
            foreach ($request->items as $itemData) {
                $item = new InvoiceItem();
                $item->invoice_id = $invoice->id;
                $item->description = $itemData['description'];
                $item->quantity = $itemData['quantity'];
                $item->unit_price = $itemData['unit_price'];
                $item->tax_rate = $itemData['tax_rate'] ?? 0;
                
                // Calculate item totals
                $itemSubtotal = $item->quantity * $item->unit_price;
                $item->tax_amount = $itemSubtotal * ($item->tax_rate / 100);
                $item->discount_amount = 0; // Not implemented at item level yet
                $item->total = $itemSubtotal + $item->tax_amount;
                
                $item->save();
                
                $subtotal += $item->total;
            }
            
            // Update invoice totals
            $invoice->subtotal = $subtotal;
            $invoice->tax_amount = $subtotal * ($invoice->tax_rate / 100);
            $invoice->total = $invoice->subtotal + $invoice->tax_amount - $invoice->discount_amount;
            $invoice->save();
            
            DB::commit();
            
            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        $customers = Customer::orderBy('first_name')->get();
        
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $invoice->id,
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Update invoice
            $invoice->customer_id = $request->customer_id;
            $invoice->invoice_number = $request->invoice_number;
            $invoice->issue_date = $request->issue_date;
            $invoice->due_date = $request->due_date;
            $invoice->tax_rate = $request->tax_rate ?? 0;
            $invoice->discount_amount = $request->discount_amount ?? 0;
            $invoice->notes = $request->notes;
            $invoice->status = $request->status;
            
            if ($request->status === 'paid' && !$invoice->payment_date) {
                $invoice->payment_date = now();
                $invoice->payment_method = $request->payment_method ?? 'Unknown';
            }
            
            // Delete existing items not in the request
            $existingItemIds = collect($request->items)
                ->pluck('id')
                ->filter()
                ->toArray();
            
            InvoiceItem::where('invoice_id', $invoice->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();
            
            // Add/update invoice items
            $subtotal = 0;
            
            foreach ($request->items as $itemData) {
                if (!empty($itemData['id'])) {
                    $item = InvoiceItem::find($itemData['id']);
                } else {
                    $item = new InvoiceItem();
                    $item->invoice_id = $invoice->id;
                }
                
                $item->description = $itemData['description'];
                $item->quantity = $itemData['quantity'];
                $item->unit_price = $itemData['unit_price'];
                $item->tax_rate = $itemData['tax_rate'] ?? 0;
                
                // Calculate item totals
                $itemSubtotal = $item->quantity * $item->unit_price;
                $item->tax_amount = $itemSubtotal * ($item->tax_rate / 100);
                $item->discount_amount = 0; // Not implemented at item level yet
                $item->total = $itemSubtotal + $item->tax_amount;
                
                $item->save();
                
                $subtotal += $item->total;
            }
            
            // Update invoice totals
            $invoice->subtotal = $subtotal;
            $invoice->tax_amount = $subtotal * ($invoice->tax_rate / 100);
            $invoice->total = $invoice->subtotal + $invoice->tax_amount - $invoice->discount_amount;
            $invoice->save();
            
            DB::commit();
            
            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
            return redirect()->route('invoices.index')
                ->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for the invoice.
     */
    public function generatePdf(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        
        $pdf = PDF::loadView('pdfs.invoice', compact('invoice'));
        
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Mark invoice as paid.
     */
    public function markAsPaid(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
        ]);
        
        $invoice->status = 'paid';
        $invoice->payment_method = $request->payment_method;
        $invoice->payment_date = $request->payment_date;
        $invoice->save();
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice marked as paid.');
    }
}
