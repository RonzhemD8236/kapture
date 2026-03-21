<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public object $order,
        public array $cart,
        public float $total,
        public object $customer
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Kapture Order Confirmation — #' . $this->order->order_id);
    }

     public function content(): Content
{
    return new Content(view: 'email.order-confirmation');  // email body
}

public function attachments(): array
{
    $pdf = Pdf::loadView('email.receipt-pdf', [  // PDF attachment
        'order'    => $this->order,
        'cart'     => $this->cart,
        'total'    => $this->total,
        'customer' => $this->customer,
    ]);

    return [
        Attachment::fromData(
            fn () => $pdf->output(),
            'receipt-' . $this->order->order_id . '.pdf'
        )->withMime('application/pdf'),
    ];
}
}