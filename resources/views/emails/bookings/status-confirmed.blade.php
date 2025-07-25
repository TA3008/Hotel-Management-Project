<x-mail::message>
# Xin chào {{ $booking->customer_name }},

Chúng tôi vui mừng thông báo rằng **booking của bạn đã được xác nhận**!

---

## Thông tin booking

- **Mã booking:** {{ $booking->id }}
- **Ngày đặt:** {{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}
- **Trạng thái:** {{ ucfirst($booking->status) }}

---

<x-mail::button :url="url('/bookings/' . $booking->id)">
Xem chi tiết Booking
</x-mail::button>

Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.

Cảm ơn bạn đã tin tưởng **{{ config('app.name') }}**!
</x-mail::message>
