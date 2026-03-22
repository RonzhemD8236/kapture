<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Barryvdh\DomPDF\Facade\Pdf;

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
            from: new Address('noreply@kapture.com', 'Kapture'),
            subject: 'Your Kapture Order #' . str_pad($this->order->order_id, 6, '0', STR_PAD_LEFT) . ' — Status Update',
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
        // Build cart array from orderItems for the PDF template
        $cart = $this->orderItems->map(fn($item) => [
            'title'      => $item->description,
            'quantity'   => $item->quantity,
            'sell_price' => $item->sell_price,
            'subtotal'   => $item->sell_price * $item->quantity,
        ])->toArray();

        $pdf = Pdf::loadView('email.receipt-pdf', [
            'order'    => $this->order,
            'cart'     => $cart,
            'total'    => $this->orderTotal,
            'customer' => $this->customer,
        ]);

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn () => $pdf->output(),
                'receipt-' . $this->order->order_id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}