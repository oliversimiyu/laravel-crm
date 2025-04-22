<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;

class ClientEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The customer instance.
     *
     * @var Customer
     */
    public $customer;

    /**
     * The email subject.
     *
     * @var string
     */
    public $subject;

    /**
     * The email message.
     *
     * @var string
     */
    public $emailMessage;

    /**
     * Any attachments to include.
     *
     * @var array
     */
    public $attachmentPaths = [];

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, string $subject, string $emailMessage, array $attachmentPaths = [])
    {
        $this->customer = $customer;
        $this->subject = $subject;
        $this->emailMessage = $emailMessage;
        $this->attachmentPaths = $attachmentPaths;
    }

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
            view: 'emails.client',
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
        
        foreach ($this->attachmentPaths as $path) {
            $attachments[] = Attachment::fromPath($path);
        }
        
        return $attachments;
    }
}
