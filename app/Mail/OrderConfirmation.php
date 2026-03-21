<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public object $order,
        public array $cart,
        public float $total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Kapture Order Confirmation');
    }

    public function content(): Content
    {
        return new Content(view: 'email.order-confirmation');
    }
}