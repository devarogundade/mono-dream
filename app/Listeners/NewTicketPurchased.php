<?php

namespace App\Listeners;

use App\Models\Transaction;
use App\Models\User;
use App\Notifications\TicketPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewTicketPurchased implements ShouldQueue
{
    public $userticket;

    public function __construct()
    {
    }

    public function handle($event)
    {
        $userticket = $event->userticket;

        $ticket = $userticket->ticket;
        $user = $userticket->user;

        # create trx
        Transaction::create([
            'amount' => $ticket->amount,
            'user_id' => $user->id
        ]);

        # give buyer one nft
        $wallet = User::find($user->id)->wallet;

        if (!$wallet) {
            $wallet = User::find($user->id)->wallet();
            dd($wallet);

            $wallet = User::find($user->id)->wallet;
        }

        if ($ticket->amount > 0) {
            $wallet->update([
                'nfts' => $wallet->nfts + 1
            ]);
        }

        # send email to buyer
        $user->notify(new TicketPurchased($userticket));
    }
}
