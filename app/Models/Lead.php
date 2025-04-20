<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company;
use App\Models\Communication;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'position',
        'email',
        'phone',
        'source',
        'value',
        'status',
        'notes'
    ];

    protected $casts = [
        'value' => 'decimal:2'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function communications()
    {
        return $this->morphMany(Communication::class, 'communicatable');
    }
}
