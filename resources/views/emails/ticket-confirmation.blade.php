<x-mail::message>
# Thank you for your purchase!

Hello **{{ $ticket->attendee_name }}**,

Sosongo! Your payment was successful and your place at **The 2nd Global Biennial Summit for African Art & Culture 2026** is confirmed.

**Pass:** {{ $ticket->passName() }}  
**Access:** {{ $ticket->dayLabel() }}  
**Ticket code:** {{ $ticket->code }}  
**Venue:** New Culture Studios, Ibadan

Your scannable e-ticket is attached to this email as a PNG. Please keep it handy (phone or print) for check-in at the entrance.

@if($qrUrl)
<div style="text-align:center;margin:24px 0;">
<img src="{{ $qrUrl }}" alt="E-Ticket QR Code" width="200" height="200" style="border:8px solid {{ $stubColor }};padding:8px;background:{{ $stubColor }};">
<p style="font-size:12px;color:#666;">Scan this QR at the gate · {{ $ticket->code }}</p>
</div>
@endif

If the attachment doesn’t open, show this QR code or your ticket code at the entrance.

We look forward to welcoming you.

Sosongo ke unwam mfo,  
**Anyen Iyak Foundation**
</x-mail::message>
