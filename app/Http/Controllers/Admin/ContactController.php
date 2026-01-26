<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     */
    public function index(Request $request)
    {
        $query = Contact::query()->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);

        // Get statistics
        $stats = [
            'total' => Contact::count(),
            'pending' => Contact::where('status', 'new')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
            'archived' => Contact::where('status', 'archived')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Store a newly created contact (for testing purposes).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
        ]);

        try {
            // Create the contact
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => Contact::STATUS_NEW,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send notification email if configured
            try {
                $adminEmail = setting('contact_admin_email') ?? config('mail.from.address');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new \App\Mail\ContactFormMail($contact, 'admin'));
                }
            } catch (\Exception $e) {
                // Log email error but don't fail the contact creation
                \Log::warning('Failed to send contact notification email: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Test contact berhasil dibuat! Periksa daftar kontak untuk melihat hasilnya.');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal membuat test contact: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        // Mark as read if it's new
        if ($contact->is_new) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the specified contact status.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Contact::getStatuses())),
        ]);

        $oldStatus = $contact->status;
        $contact->update(['status' => $request->status]);

        // Update timestamps based on status change
        if ($request->status === Contact::STATUS_READ && $oldStatus === Contact::STATUS_NEW) {
            $contact->update(['read_at' => now()]);
        } elseif ($request->status === Contact::STATUS_REPLIED) {
            $contact->update(['replied_at' => now()]);
        }

        return redirect()->back()->with('success', 'Contact status updated successfully.');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Contact deleted successfully.');
    }

    /**
     * Show reply form
     */
    public function reply(Contact $contact)
    {
        return view('admin.contacts.reply', compact('contact'));
    }

    /**
     * Send reply email
     */
    public function sendReply(Request $request, Contact $contact)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Sanitize HTML content for security
            $cleanMessage = $this->sanitizeHtmlContent($request->message);
            
            // Send reply email
            Mail::to($contact->email)->send(new ContactReplyMail(
                $contact,
                $request->subject,
                $cleanMessage
            ));

            // Mark as replied
            $contact->markAsReplied();

            return redirect()->route('admin.contacts.show', $contact)
                           ->with('success', 'Reply sent successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to send reply. Please try again.')
                           ->withInput();
        }
    }

    /**
     * Sanitize HTML content for email
     */
    private function sanitizeHtmlContent($html)
    {
        // Allow safe HTML tags for email
        $allowedTags = '<p><br><strong><b><em><i><u><ul><ol><li><a><img><h1><h2><h3><h4><h5><h6><blockquote><table><tr><td><th><thead><tbody><tfoot>';
        
        // Strip dangerous tags but keep safe ones
        $cleaned = strip_tags($html, $allowedTags);
        
        // Remove potentially dangerous attributes except safe ones
        $cleaned = preg_replace('/(<[^>]+) (on\w+|javascript:|vbscript:|data:(?!image))[^>]*>/i', '$1>', $cleaned);
        
        // Ensure images use absolute URLs
        $cleaned = preg_replace_callback('/(<img[^>]+src=["\'])([^"\']+)(["\'][^>]*>)/i', function($matches) {
            $url = $matches[2];
            if (!preg_match('/^https?:\/\//', $url)) {
                // Convert relative URLs to absolute
                $url = url($url);
            }
            return $matches[1] . $url . $matches[3];
        }, $cleaned);
        
        return $cleaned;
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_replied,archive,delete',
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
        ]);

        $contacts = Contact::whereIn('id', $request->contacts);

        switch ($request->action) {
            case 'mark_read':
                $contacts->update([
                    'status' => Contact::STATUS_READ,
                    'read_at' => now()
                ]);
                $message = 'Selected contacts marked as read.';
                break;

            case 'mark_replied':
                $contacts->update([
                    'status' => Contact::STATUS_REPLIED,
                    'replied_at' => now()
                ]);
                $message = 'Selected contacts marked as replied.';
                break;

            case 'archive':
                $contacts->update(['status' => Contact::STATUS_ARCHIVED]);
                $message = 'Selected contacts archived.';
                break;

            case 'delete':
                $contacts->delete();
                $message = 'Selected contacts deleted.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export contacts
     */
    public function export(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->get();

        $filename = 'contacts_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($contacts) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Phone', 'Company', 'Subject', 
                'Message', 'Status', 'Submitted At', 'Read At', 'Replied At'
            ]);

            // CSV data
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->company,
                    $contact->subject,
                    $contact->message,
                    $contact->status_label,
                    $contact->created_at->format('Y-m-d H:i:s'),
                    $contact->read_at?->format('Y-m-d H:i:s'),
                    $contact->replied_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
