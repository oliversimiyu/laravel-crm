<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'subject',
        'description',
        'loggable_type',
        'loggable_id',
        'properties',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model that the activity was performed on.
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the icon for this activity type.
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'create' => '✚',
            'update' => '✎',
            'delete' => '✖',
            'email' => '✉',
            'call' => '☎',
            'meeting' => '👥',
            'note' => '📝',
            'task' => '✓',
            'sale' => '$',
            'payment' => '💰',
            'invoice' => '📄',
            'quote' => '📋',
            default => '•',
        };
    }

    /**
     * Get the color for this activity type.
     */
    public function getColorAttribute(): string
    {
        // Check if this activity is related to an invoice or quote
        $isInvoice = str_contains(strtolower($this->loggable_type ?? ''), 'invoice');
        $isQuote = str_contains(strtolower($this->loggable_type ?? ''), 'quote');
        
        if ($isInvoice) {
            return match($this->type) {
                'payment' => 'green',
                'email' => 'purple',
                default => 'blue',
            };
        }
        
        if ($isQuote) {
            return match($this->type) {
                'email' => 'purple',
                default => 'green',
            };
        }
        
        return match($this->type) {
            'create' => 'green',
            'update' => 'blue',
            'delete' => 'red',
            'email' => 'purple',
            'call' => 'orange',
            'meeting' => 'indigo',
            'note' => 'teal',
            'task' => 'green',
            'sale' => 'green',
            'payment' => 'green',
            'invoice' => 'blue',
            'quote' => 'green',
            default => 'gray',
        };
    }
}
