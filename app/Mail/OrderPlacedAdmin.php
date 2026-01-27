<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function build(): self
    {
        return $this->subject('Nouvelle commande #' . $this->order->id . ' — Maison 216')
            ->view('emails.order_placed_admin', [
                'order' => $this->order,
            ]);
    }
}
