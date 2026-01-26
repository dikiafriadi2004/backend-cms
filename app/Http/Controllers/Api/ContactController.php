<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Submit a contact form
     */
    public function store(ContactRequest $request): JsonResponse
    {
        try {
            // Rate limiting - 5 submissions per hour per IP
            $key = 'contact-form:' . $request->ip();
            
            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Too many contact form submissions. Please try again in ' . ceil($seconds / 60) . ' minutes.',
                    'errors' => [
                        'rate_limit' => ['You have exceeded the maximum number of submissions allowed per hour.']
                    ]
                ], 429);
            }

            // Collect metadata
            $metadata = [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'submitted_at' => now()->toISOString(),
            ];

            // Create contact record
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'subject' => $request->subject,
                'message' => $request->message,
                'metadata' => $metadata,
            ]);

            // Send email notification
            $this->sendContactEmail($contact);

            // Increment rate limiter
            RateLimiter::hit($key, 3600); // 1 hour

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
                'data' => [
                    'id' => $contact->id,
                    'submitted_at' => $contact->created_at->toISOString(),
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error processing your request. Please try again later.',
                'errors' => [
                    'system' => ['An unexpected error occurred. Please contact support if the problem persists.']
                ]
            ], 500);
        }
    }

    /**
     * Get contact form configuration
     */
    public function config(): JsonResponse
    {
        try {
            $settings = [
                'contact_email' => setting('contact_email', config('mail.from.address')),
                'contact_phone' => setting('contact_phone', ''),
                'contact_address' => setting('contact_address', ''),
                'business_hours' => setting('business_hours', ''),
                'auto_reply_enabled' => setting('contact_auto_reply_enabled', true),
                'rate_limit' => [
                    'max_attempts' => 5,
                    'decay_minutes' => 60,
                ],
                'required_fields' => ['name', 'email', 'subject', 'message'],
                'optional_fields' => ['phone', 'company'],
            ];

            return response()->json([
                'success' => true,
                'data' => $settings
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get contact config', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load contact configuration.',
            ], 500);
        }
    }

    /**
     * Send contact form email
     */
    private function sendContactEmail(Contact $contact): void
    {
        try {
            $adminEmail = setting('contact_email', config('mail.from.address'));
            $autoReplyEnabled = setting('contact_auto_reply_enabled', true);

            // Send notification to admin
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new ContactFormMail($contact, 'admin'));
            }

            // Send auto-reply to user if enabled
            if ($autoReplyEnabled) {
                Mail::to($contact->email)->send(new ContactFormMail($contact, 'user'));
            }

        } catch (\Exception $e) {
            Log::error('Failed to send contact email', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage()
            ]);
            
            // Don't throw exception here to avoid breaking the contact submission
            // The contact is still saved even if email fails
        }
    }
}
