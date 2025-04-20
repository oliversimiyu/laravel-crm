<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;
use App\Models\Lead;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'industry',
        'website',
        'phone',
        'email',
        'address',
        'notes'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
