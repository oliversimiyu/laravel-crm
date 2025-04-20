<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use App\Models\Sale;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'customer_id',
        'lead_id',
        'created_by',
        'subtotal',
        'tax',
        'total',
        'status',
        'terms',
        'notes',
        'valid_until'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'valid_until' => 'date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }
}
