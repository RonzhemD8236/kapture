<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class SendOrderStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $orderItems;
    public $orderTotal;
    public $customer;

    public function __construct($order, $orderItems, $orderTotal, $customer)
    {
        $this->order      = $order;
        $this->orderItems = $orderItems;
        $this->orderTotal = $orderTotal;
        $this->customer   = $customer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@larashop.test', 'Kapture'),
            subject: 'Your Kapture Order Status Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.order_status',
            with: [
                'order'      => $this->order,
                'orderItems' => $this->orderItems,
                'orderTotal' => $this->orderTotal,
                'customer'   => $this->customer,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}