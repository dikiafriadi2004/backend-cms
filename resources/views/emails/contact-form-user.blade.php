<x-mail::message>
# ✅ Pesan Anda Telah Diterima!

Kepada Yth. **{{ $contact->name }}**,

Terima kasih telah menghubungi kami. Kami dengan senang hati mengonfirmasi bahwa pesan Anda telah berhasil diterima dan akan segera ditinjau oleh tim kami.

## 📋 Detail Pesan Anda

<div style="background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 16px; border-radius: 8px; margin: 16px 0;">
**📌 ID Tiket:** #{{ str_pad($contact->id, 6, '0', STR_PAD_LEFT) }}  
**📝 Subjek:** {{ $contact->subject }}  
**📅 Tanggal:** {{ $contact->created_at ? $contact->created_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB  
**⏱️ Estimasi Respons:** {{ setting('response_time', '24-48 jam') }}
</div>

## 💬 Pesan Anda

<div style="background-color: #f0f9ff; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; border-radius: 4px;">
{{ $contact->message }}
</div>

## 🔄 Langkah Selanjutnya

<div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; padding: 16px; border-radius: 8px; margin: 16px 0;">
1. **Tim kami akan meninjau** pesan Anda dengan seksama
2. **Anda akan menerima balasan** melalui email dalam {{ setting('response_time', '24-48 jam') }}
3. **Simpan ID tiket** (#{{ str_pad($contact->id, 6, '0', STR_PAD_LEFT) }}) untuk referensi komunikasi selanjutnya
</div>

## 📞 Butuh Bantuan Segera?

Jika Anda memiliki pertanyaan mendesak, silakan hubungi kami langsung:

<div style="background-color: #fef3c7; border: 1px solid #fcd34d; padding: 16px; border-radius: 8px; margin: 16px 0;">
@if($contactPhone)
**📱 Telepon:** {{ $contactPhone }}  
@endif
**📧 Email:** {{ $contactEmail }}  
@if(isset($contactAddress) && $contactAddress)
**📍 Alamat:** {{ $contactAddress }}  
@endif
**🌐 Website:** {{ $siteUrl }}
</div>

<x-mail::button :url="$siteUrl" color="primary">
Kunjungi Website Kami
</x-mail::button>

<div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
<p style="margin: 0; color: #6b7280; font-size: 14px;">
Kami menghargai kepercayaan Anda dan berkomitmen untuk memberikan respons yang cepat dan berkualitas.
</p>
</div>

Hormat kami,  
**Tim {{ $siteName }}**

<div style="margin-top: 16px; padding: 12px; background-color: #f0f9ff; border-radius: 6px; font-size: 12px; color: #1e40af;">
<strong>💡 Tips:</strong> Untuk mempercepat proses, pastikan email ini tidak masuk ke folder spam. Tambahkan {{ $contactEmail }} ke daftar kontak Anda.
</div>
</x-mail::message>