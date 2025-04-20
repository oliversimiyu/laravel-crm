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
        return $this->hasMany(Lead::class);
    }

    public function communications()
    {
        return $this->hasMany(Communication::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
