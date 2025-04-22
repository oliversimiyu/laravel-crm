<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Invoice $invoice,
        public string $emailMessage = '',
        public string $emailSubject = 'Your Invoice',
        public bool $attachPdf = true
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
            with: [
                'invoice' => $this->invoice,
                'message' => (string)$this->emailMessage,
                'customerName' => $this->invoice->customer->full_name,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->attachPdf) {
            // Generate PDF and attach it
            $pdf = \PDF::loadView('pdfs.invoice', ['invoice' => $this->invoice]);
            
            $attachments[] = Attachment::fromData(fn () => $pdf->output(), 'invoice-' . $this->invoice->invoice_number . '.pdf')
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }
}
