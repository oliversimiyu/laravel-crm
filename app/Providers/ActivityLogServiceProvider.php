<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Quote;
use App\Services\ActivityService;
use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Log invoice activities
        Invoice::created(function ($invoice) {
            $this->logActivity('create', 'invoice', $invoice, 'Invoice created');
        });
        
        Invoice::updated(function ($invoice) {
            if ($invoice->isDirty('status')) {
                $newStatus = $invoice->status;
                $oldStatus = $invoice->getOriginal('status');
                
                if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                    $this->logActivity('payment', 'invoice', $invoice, 'Invoice marked as paid');
                } elseif ($newStatus === 'sent' && $oldStatus !== 'sent') {
                    $this->logActivity('email', 'invoice', $invoice, 'Invoice sent to customer');
                } else {
                    $this->logActivity('update', 'invoice', $invoice, 'Invoice updated');
                }
            } else {
                $this->logActivity('update', 'invoice', $invoice, 'Invoice updated');
            }
        });
        
        Invoice::deleted(function ($invoice) {
            $this->logActivity('delete', 'invoice', $invoice, 'Invoice deleted');
        });
        
        // Log quote activities
        Quote::created(function ($quote) {
            $this->logActivity('create', 'quote', $quote, 'Quote created');
        });
        
        Quote::updated(function ($quote) {
            if ($quote->isDirty('status')) {
                $newStatus = $quote->status;
                $oldStatus = $quote->getOriginal('status');
                
                if ($newStatus === 'accepted' && $oldStatus !== 'accepted') {
                    $this->logActivity('update', 'quote', $quote, 'Quote accepted by customer');
                } elseif ($newStatus === 'sent' && $oldStatus !== 'sent') {
                    $this->logActivity('email', 'quote', $quote, 'Quote sent to customer');
                } else {
                    $this->logActivity('update', 'quote', $quote, 'Quote updated');
                }
            } else {
                $this->logActivity('update', 'quote', $quote, 'Quote updated');
            }
        });
        
        Quote::deleted(function ($quote) {
            $this->logActivity('delete', 'quote', $quote, 'Quote deleted');
        });
    }
    
    /**
     * Log an activity using the ActivityService.
     */
    private function logActivity(string $type, string $modelType, $model, string $description): void
    {
        if (app()->bound(ActivityService::class)) {
            $activityService = app()->make(ActivityService::class);
            $activityService->log(
                $type,
                $model->invoice_number ?? $model->quote_number ?? "#{$model->id}",
                $model,
                $description
            );
        }
    }
}
