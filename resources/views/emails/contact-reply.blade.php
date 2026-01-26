<x-mail::message>
# Balasan untuk Pertanyaan Anda

Kepada Yth. **{{ $contact->name }}**,

Terima kasih telah menghubungi kami. Kami telah menerima dan meninjau pertanyaan Anda mengenai "**{{ $contact->subject }}**" dengan seksama.

## 💬 Balasan Kami

<div style="background-color: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; border-radius: 4px;">
{!! $replyMessage !!}
</div>

## 📝 Pesan Asli Anda
<div style="background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 12px; border-radius: 6px; margin: 16px 0;">
<small style="color: #6b7280; font-weight: 600;">Dikirim pada: {{ $contact->created_at ? $contact->created_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB</small>

<div style="margin-top: 8px; color: #374151; line-height: 1.6;">
{{ $contact->message }}
</div>
</div>

---

## � Butuh Bantuan Lebih Lanjut?

Jika Anda memiliki pertanyaan tambahan atau memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami:

<div style="background-color: #f0f9ff; border: 1px solid #bae6fd; padding: 16px; border-radius: 8px; margin: 16px 0;">
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
Terima kasih telah mempercayai layanan kami. Kami berkomitmen untuk memberikan pelayanan terbaik kepada Anda.
</p>
</div>

Hormat kami,  
**Tim {{ $siteName }}**

<div style="margin-top: 16px; padding: 12px; background-color: #fef3c7; border-radius: 6px; font-size: 12px; color: #92400e;">
<strong>💡 Tips:</strong> Simpan email ini sebagai referensi untuk komunikasi selanjutnya. Jika Anda membalas email ini, pastikan untuk menyertakan riwayat percakapan agar kami dapat membantu Anda dengan lebih baik.
</div>
</x-mail::message>