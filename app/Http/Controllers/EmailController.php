<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Mail\ClientEmail;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Show the email compose form.
     *
     * @return \Illuminate\View\View
     */
    public function compose(Request $request)
    {
        $customers = Customer::all();
        $selectedCustomerId = $request->input('customer_id');
        
        return view('emails.compose', compact('customers', 'selectedCustomerId'));
    }

    /**
     * Send an email to a customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        
        // Handle file attachments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email-attachments', 'public');
                $attachmentPaths[] = Storage::disk('public')->path($path);
            }
        }

        try {
            // Create and send the email
            Mail::to($customer->email)
                ->send(new ClientEmail($customer, $request->subject, $request->message, $attachmentPaths));

            // Log the communication
            $communication = $customer->communications()->create([
                'type' => 'email',
                'subject' => $request->subject,
                'content' => $request->message,
                'status' => 'sent',
                'scheduled_at' => now(),
            ]);

            // Log activity
            $this->activityService->log(
                'email',
                'Sent email to ' . $customer->first_name . ' ' . $customer->last_name,
                $communication,
                $request->subject,
                ['recipient' => $customer->email]
            );

            return redirect()->route('customers.show', $customer)
                ->with('success', 'Email sent successfully to ' . $customer->first_name . ' ' . $customer->last_name);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Email sending failed: ' . $e->getMessage());
            
            // Log failed activity
            $this->activityService->log(
                'email',
                'Failed to send email to ' . $customer->first_name . ' ' . $customer->last_name,
                $customer,
                'Error: ' . $e->getMessage(),
                ['subject' => $request->subject]
            );

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to send email. Error: ' . $e->getMessage());
        }
    }
}
