<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Company;
use App\Models\Lead;
use App\Models\Communication;
use App\Models\Task;
use App\Models\Quotation;
use App\Models\Sale;
use App\Models\Invoice;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'company_id',
        'notes'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'email', 'email');
    }

    public function communications()
    {
        return $this->morphMany(Communication::class, 'communicatable');
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
