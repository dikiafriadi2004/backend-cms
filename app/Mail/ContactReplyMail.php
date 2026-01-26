<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $replySubject;
    public $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact, string $replySubject, string $replyMessage)
    {
        $this->contact = $contact;
        $this->replySubject = $replySubject;
        $this->replyMessage = $replyMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->replySubject,
            from: setting('contact_email', config('mail.from.address')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-reply',
            with: [
                'contact' => $this->contact,
                'replyMessage' => $this->replyMessage,
                'siteName' => setting('site_name', config('app.name')),
                'siteUrl' => config('app.url'),
                'contactEmail' => setting('contact_email', config('mail.from.address')),
                'contactPhone' => setting('contact_phone', ''),
                'contactAddress' => setting('contact_address', ''),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
