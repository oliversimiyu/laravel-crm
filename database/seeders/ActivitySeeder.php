<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a user
        $user = User::first() ?? User::factory()->create([
            'name' => 'Oliver',
            'email' => 'oliver@laravelcrm.com',
        ]);
        
        // Get or create a customer
        $customer = Customer::first() ?? Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
        ]);
        
        // Get or create an invoice
        $invoice = Invoice::first() ?? Invoice::create([
            'invoice_number' => 'INV-001',
            'customer_id' => $customer->id,
            'issue_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'tax_rate' => 16,
            'tax_amount' => 160,
            'total' => 1160,
            'status' => 'sent',
        ]);
        
        // Get or create a quote
        $quote = Quote::first() ?? Quote::create([
            'quote_number' => 'QT-001',
            'customer_id' => $customer->id,
            'issue_date' => now(),
            'expiry_date' => now()->addDays(14),
            'subtotal' => 800,
            'tax_rate' => 16,
            'tax_amount' => 128,
            'total' => 928,
            'status' => 'sent',
        ]);
        
        // Create sample activities
        $activities = [
            [
                'user_id' => $user->id,
                'type' => 'create',
                'subject' => 'New Customer',
                'description' => 'Created a new customer record',
                'loggable_type' => Customer::class,
                'loggable_id' => $customer->id,
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(30),
            ],
            [
                'user_id' => $user->id,
                'type' => 'create',
                'subject' => $invoice->invoice_number,
                'description' => 'Created a new invoice',
                'loggable_type' => Invoice::class,
                'loggable_id' => $invoice->id,
                'created_at' => now()->subMinutes(25),
                'updated_at' => now()->subMinutes(25),
            ],
            [
                'user_id' => $user->id,
                'type' => 'email',
                'subject' => $invoice->invoice_number,
                'description' => 'Sent invoice to customer',
                'loggable_type' => Invoice::class,
                'loggable_id' => $invoice->id,
                'created_at' => now()->subMinutes(20),
                'updated_at' => now()->subMinutes(20),
            ],
            [
                'user_id' => $user->id,
                'type' => 'create',
                'subject' => $quote->quote_number,
                'description' => 'Created a new quote',
                'loggable_type' => Quote::class,
                'loggable_id' => $quote->id,
                'created_at' => now()->subMinutes(15),
                'updated_at' => now()->subMinutes(15),
            ],
            [
                'user_id' => $user->id,
                'type' => 'email',
                'subject' => $quote->quote_number,
                'description' => 'Sent quote to customer',
                'loggable_type' => Quote::class,
                'loggable_id' => $quote->id,
                'created_at' => now()->subMinutes(10),
                'updated_at' => now()->subMinutes(10),
            ],
            [
                'user_id' => $user->id,
                'type' => 'payment',
                'subject' => $invoice->invoice_number,
                'description' => 'Invoice marked as paid',
                'loggable_type' => Invoice::class,
                'loggable_id' => $invoice->id,
                'created_at' => now()->subMinutes(5),
                'updated_at' => now()->subMinutes(5),
            ],
        ];
        
        // Insert activities
        foreach ($activities as $activity) {
            Activity::updateOrCreate(
                [
                    'user_id' => $activity['user_id'],
                    'type' => $activity['type'],
                    'subject' => $activity['subject'],
                    'loggable_type' => $activity['loggable_type'],
                    'loggable_id' => $activity['loggable_id'],
                    'created_at' => $activity['created_at'],
                ],
                $activity
            );
        }
    }
}
