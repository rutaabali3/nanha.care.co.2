<?php

namespace App\Services;

use App\Contracts\IEmailService;
use App\Models\Babysitting\Booking;
use App\Models\Marketplace\Order;
use App\Models\Support\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailService implements IEmailService
{
    public function sendWelcome(string $userId): void
    {
        $user = User::findOrFail($userId);
        Mail::raw('Welcome to NanhaCare!', function ($message) use ($user) {
            $message->to($user->email)->subject('Welcome to NanhaCare');
        });
    }

    public function sendBookingConfirmation(int $bookingId): void
    {
        $booking = Booking::with('parent', 'babysitter')->findOrFail($bookingId);
        Mail::raw('Your booking has been confirmed.', function ($message) use ($booking) {
            $message->to($booking->parent->email)->subject('Booking Confirmed');
        });
    }

    public function sendOrderConfirmation(int $orderId): void
    {
        $order = Order::with('parent')->findOrFail($orderId);
        Mail::raw('Your order has been placed.', function ($message) use ($order) {
            $message->to($order->parent->email)->subject('Order Confirmed');
        });
    }

    public function sendPasswordReset(string $email, string $token): void
    {
        Mail::raw('Your password reset token: '.$token, function ($message) use ($email) {
            $message->to($email)->subject('Password Reset');
        });
    }

    public function sendContactReply(int $ticketId): void
    {
        $ticket = SupportTicket::with('user')->findOrFail($ticketId);
        Mail::raw('Your support ticket has been replied to.', function ($message) use ($ticket) {
            $message->to($ticket->user->email)->subject('Support Ticket Reply');
        });
    }
}
