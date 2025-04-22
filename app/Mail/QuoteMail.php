<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Quote $quote,
        public string $emailMessage = '',
        public string $subject = 'Your Quote',
        public bool $attachPdf = true
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quote',
            with: [
                'quote' => $this->quote,
                'message' => $this->emailMessage,
                'customerName' => $this->quote->customer->full_name,
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
            $pdf = \PDF::loadView('pdfs.quote', ['quote' => $this->quote]);
            
            $attachments[] = Attachment::fromData(fn () => $pdf->output(), 'quote-' . $this->quote->quote_number . '.pdf')
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }
}
