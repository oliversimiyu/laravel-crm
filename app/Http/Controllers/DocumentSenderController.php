<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Mail\QuoteMail;
use App\Models\Invoice;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocumentSenderController extends Controller
{
    /**
     * Show the form to send an invoice via email.
     */
    public function showSendInvoiceForm(Invoice $invoice)
    {
        return view('invoices.send', compact('invoice'));
    }

    /**
     * Send an invoice via email.
     */
    public function sendInvoice(Request $request, Invoice $invoice)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attach_pdf' => 'boolean',
        ]);

        $attachPdf = $request->has('attach_pdf');
        
        // Send the email
        Mail::to($request->email)
            ->send(new InvoiceMail(
                $invoice,
                (string) $request->input('message', ''),
                $request->subject,
                $attachPdf
            ));
        
        // Update invoice status to sent if it was in draft
        if ($invoice->status === 'draft') {
            $invoice->status = 'sent';
            $invoice->save();
        }
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice has been sent successfully.');
    }

    /**
     * Show the form to send a quote via email.
     */
    public function showSendQuoteForm(Quote $quote)
    {
        return view('quotes.send', compact('quote'));
    }

    /**
     * Send a quote via email.
     */
    public function sendQuote(Request $request, Quote $quote)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attach_pdf' => 'boolean',
        ]);

        $attachPdf = $request->has('attach_pdf');
        $messageText = (string) $request->input('message', '');
        
        // Send the email
        Mail::to($request->email)
            ->send(new QuoteMail(
                $quote,
                $messageText,
                $request->subject,
                $attachPdf
            ));
        
        // Update quote status to sent if it was in draft
        if ($quote->status === 'draft') {
            $quote->status = 'sent';
            $quote->save();
        }
        
        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote has been sent successfully.');
    }
}
