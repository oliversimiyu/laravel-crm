<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_number',
        'customer_id',
        'issue_date',
        'expiry_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_amount',
        'total',
        'notes',
        'status',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the quote.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the items for the quote.
     */
    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    /**
     * Generate a unique quote number.
     */
    public static function generateQuoteNumber(): string
    {
        $prefix = 'QUO-';
        $year = date('Y');
        $month = date('m');
        
        $lastQuote = self::orderBy('id', 'desc')->first();
        
        if ($lastQuote) {
            $lastNumber = (int) substr($lastQuote->quote_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate quote totals.
     */
    public function calculateTotals(): void
    {
        $subtotal = $this->items->sum('total');
        $this->subtotal = $subtotal;
        
        // Calculate tax amount based on tax rate
        $this->tax_amount = $subtotal * ($this->tax_rate / 100);
        
        // Calculate total
        $this->total = $subtotal + $this->tax_amount - $this->discount_amount;
        
        $this->save();
    }

    /**
     * Convert quote to invoice.
     */
    public function convertToInvoice(): Invoice
    {
        $invoice = new Invoice([
            'customer_id' => $this->customer_id,
            'issue_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => $this->subtotal,
            'tax_rate' => $this->tax_rate,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total' => $this->total,
            'notes' => $this->notes,
            'status' => 'draft',
        ]);
        
        $invoice->invoice_number = Invoice::generateInvoiceNumber();
        $invoice->save();
        
        // Copy quote items to invoice items
        foreach ($this->items as $quoteItem) {
            $invoiceItem = new InvoiceItem([
                'invoice_id' => $invoice->id,
                'description' => $quoteItem->description,
                'quantity' => $quoteItem->quantity,
                'unit_price' => $quoteItem->unit_price,
                'tax_rate' => $quoteItem->tax_rate,
                'tax_amount' => $quoteItem->tax_amount,
                'discount_amount' => $quoteItem->discount_amount,
                'total' => $quoteItem->total,
            ]);
            
            $invoiceItem->save();
        }
        
        // Update quote status
        $this->status = 'accepted';
        $this->save();
        
        return $invoice;
    }

    /**
     * Check if the quote is expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date < now();
    }
}
