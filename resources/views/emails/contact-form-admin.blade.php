<x-mail::message>
# 📧 Formulir Kontak Baru Diterima

Anda telah menerima pesan baru melalui formulir kontak di website **{{ $siteName }}**.

## 👤 Detail Kontak

<x-mail::panel>
**👤 Nama:** {{ $contact->name }}

**📧 Email:** {{ $contact->email }}

@if($contact->phone)
**📱 Telepon:** {{ $contact->phone }}
@endif

@if($contact->company)
**🏢 Perusahaan:** {{ $contact->company }}
@endif

**📝 Subjek:** {{ $contact->subject }}

**🕒 Dikirim:** {{ $contact->created_at ? $contact->created_at->format('d F Y H:i') : now()->format('d F Y H:i') }} WIB
</x-mail::panel>

## 💬 Pesan

<x-mail::panel>
{{ $contact->message }}
</x-mail::panel>

## ⚡ Tindakan Cepat

@if($contact->id && $contact->id !== 999)
<x-mail::button :url="route('admin.contacts.show', $contact->id)" color="primary">
🔍 Lihat di Panel Admin
</x-mail::button>
@endif

<x-mail::button :url="'mailto:' . $contact->email . '?subject=Re: ' . urlencode($contact->subject)" color="success">
↩️ Balas via Email
</x-mail::button>

---

Salam hormat,  
**Sistem Kontak {{ $siteName }}**

<x-slot:subcopy>
Ini adalah notifikasi otomatis dari formulir kontak website Anda.
@if($contact->id && $contact->id !== 999)
Anda dapat mengelola semua pesan kontak di panel admin.
@endif
</x-slot:subcopy>
</x-mail::message>