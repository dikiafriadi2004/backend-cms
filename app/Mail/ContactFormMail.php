<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $type; // 'admin' or 'user'

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact, string $type = 'admin')
    {
        $this->contact = $contact;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->type === 'admin') {
            return new Envelope(
                subject: 'Formulir Kontak Baru: ' . $this->contact->subject,
                replyTo: $this->contact->email,
            );
        } else {
            return new Envelope(
                subject: 'Terima kasih telah menghubungi kami - ' . setting('site_name', config('app.name')),
                from: setting('contact_email', config('mail.from.address')),
            );
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->type === 'admin') {
            return new Content(
                markdown: 'emails.contact-form-admin',
                with: [
                    'contact' => $this->contact,
                    'siteName' => setting('site_name', config('app.name')),
                    'siteUrl' => config('app.url'),
                ]
            );
        } else {
            return new Content(
                markdown: 'emails.contact-form-user',
                with: [
                    'contact' => $this->contact,
                    'siteName' => setting('site_name', config('app.name')),
                    'siteUrl' => config('app.url'),
                    'contactEmail' => setting('contact_email', config('mail.from.address')),
                    'contactPhone' => setting('contact_phone', ''),
                    'contactAddress' => setting('contact_address', ''),
                    'businessHours' => setting('business_hours', ''),
                ]
            );
        }
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
