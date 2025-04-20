<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'subject',
        'content',
        'communicatable_type',
        'communicatable_id',
        'scheduled_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime'
    ];

    public function communicatable()
    {
        return $this->morphTo();
    }
}
