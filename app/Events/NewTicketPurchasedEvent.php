<?php

namespace App\Events;

use App\Models\UserTicket;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTicketPurchasedEvent
{
    use Dispatchable, SerializesModels;

    public $userticket;

    public function __construct($bundle)
    {
        # bundle array of ticket and user objs
        $this->userticket = UserTicket::create([
            'ticket_id' => $bundle[0]->id,
            'user_id' => $bundle[1]->id,
        ]);
    }

}
