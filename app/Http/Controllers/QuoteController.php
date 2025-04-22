<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Quote::with('customer')->latest();
        
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
                $q->where('quote_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $quotes = $query->paginate(10);
        $customers = Customer::orderBy('first_name')->get();
        
        return view('quotes.index', compact('quotes', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('first_name')->get();
        $quote_number = Quote::generateQuoteNumber();
        
        return view('quotes.create', compact('customers', 'quote_number'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_number' => 'required|string|unique:quotes',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:issue_date',
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
            // Create quote
            $quote = new Quote();
            $quote->customer_id = $request->customer_id;
            $quote->quote_number = $request->quote_number;
            $quote->issue_date = $request->issue_date;
            $quote->expiry_date = $request->expiry_date;
            $quote->tax_rate = $request->tax_rate ?? 0;
            $quote->discount_amount = $request->discount_amount ?? 0;
            $quote->notes = $request->notes;
            $quote->status = 'draft';
            $quote->subtotal = 0; // Will be calculated
            $quote->tax_amount = 0; // Will be calculated
            $quote->total = 0; // Will be calculated
            $quote->save();
            
            // Add quote items
            $subtotal = 0;
            
            foreach ($request->items as $itemData) {
                $item = new QuoteItem();
                $item->quote_id = $quote->id;
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
            
            // Update quote totals
            $quote->subtotal = $subtotal;
            $quote->tax_amount = $subtotal * ($quote->tax_rate / 100);
            $quote->total = $quote->subtotal + $quote->tax_amount - $quote->discount_amount;
            $quote->save();
            
            DB::commit();
            
            return redirect()->route('quotes.show', $quote)
                ->with('success', 'Quote created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating quote: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        $quote->load(['customer', 'items']);
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        $quote->load(['customer', 'items']);
        $customers = Customer::orderBy('first_name')->get();
        
        return view('quotes.edit', compact('quote', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_number' => 'required|string|unique:quotes,quote_number,' . $quote->id,
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:issue_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,accepted,rejected,expired',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:quote_items,id',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Update quote
            $quote->customer_id = $request->customer_id;
            $quote->quote_number = $request->quote_number;
            $quote->issue_date = $request->issue_date;
            $quote->expiry_date = $request->expiry_date;
            $quote->tax_rate = $request->tax_rate ?? 0;
            $quote->discount_amount = $request->discount_amount ?? 0;
            $quote->notes = $request->notes;
            $quote->status = $request->status;
            
            // Delete existing items not in the request
            $existingItemIds = collect($request->items)
                ->pluck('id')
                ->filter()
                ->toArray();
            
            QuoteItem::where('quote_id', $quote->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();
            
            // Add/update quote items
            $subtotal = 0;
            
            foreach ($request->items as $itemData) {
                if (!empty($itemData['id'])) {
                    $item = QuoteItem::find($itemData['id']);
                } else {
                    $item = new QuoteItem();
                    $item->quote_id = $quote->id;
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
            
            // Update quote totals
            $quote->subtotal = $subtotal;
            $quote->tax_amount = $subtotal * ($quote->tax_rate / 100);
            $quote->total = $quote->subtotal + $quote->tax_amount - $quote->discount_amount;
            $quote->save();
            
            DB::commit();
            
            return redirect()->route('quotes.show', $quote)
                ->with('success', 'Quote updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating quote: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        try {
            $quote->delete();
            return redirect()->route('quotes.index')
                ->with('success', 'Quote deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting quote: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for the quote.
     */
    public function generatePdf(Quote $quote)
    {
        $quote->load(['customer', 'items']);
        
        $pdf = PDF::loadView('pdfs.quote', compact('quote'));
        
        return $pdf->download('quote-' . $quote->quote_number . '.pdf');
    }

    /**
     * Convert quote to invoice.
     */
    public function convertToInvoice(Quote $quote)
    {
        try {
            $invoice = $quote->convertToInvoice();
            
            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Quote converted to invoice successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error converting quote to invoice: ' . $e->getMessage());
        }
    }
}
