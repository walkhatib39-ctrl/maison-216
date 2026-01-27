<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedClient extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function build(): self
    {
        return $this->subject('Confirmation de votre commande #' . $this->order->id . ' — Maison 216')
            ->view('emails.order_placed_client', [
                'order' => $this->order,
            ]);
    }
}
