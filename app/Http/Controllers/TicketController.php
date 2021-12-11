<?php

namespace App\Http\Controllers;

use App\Events\NewTicketPurchasedEvent;
use App\Models\Like;
use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    # get all tickets
    public function all(Request $request)
    {
        $response = [];

        $tickets = Ticket::paginate();

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $tickets;

        return response()->json($response, 200);
    }

    public function get(String $id)
    {
        $response = [];

        $ticket = Ticket::find($id);

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $ticket;

        return response()->json($response, 200);
    }

    public function create(Request $request)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'supply' => 'integer|required|min:10|max:10000',
            'location' => 'string|required',
            'geo' => 'json|required',
            'amount' => 'integer|required',
            'location' => 'string|required',
            'schedule' => 'date|required',
            'organizer' => 'string|required',
            'start' => 'date|required',
            'end' => 'date|required',
            'user_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = $validator->errors();
            $response['data'] = null;

            return response()->json($response, 200);
        }


        $ticket = Ticket::create(
            [
                'slug' => Str::slug($request->title),
                'title' => $request->title,
                'description' => $request->description,
                'supply' => $request->supply,
                'location' => $request->location,
                'geo' => $request->geo,
                'amount' => $request->amount,
                'schedule' => $request->schedule,
                'organizer' => $request->organizer,
                'location' => $request->location,
                'start' => $request->start,
                'end' => $request->end,
                'user_id' => $request->user_id
            ]
        );

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $ticket;

        return response()->json($response, 200);
    }

    public function like(Request $request) {
        $response = [];

        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = $validator->errors();
            $response['data'] = null;

            return response()->json($response, 200);
        }

        $user = User::find($request->user_id);

        $ex = $user->likes->where('likeable_id', $request->ticket_id)
            ->where('likeable_type', 'ticket');

        if ($ex) {
            Like::find($ex->id)->delete();

            $response['status'] = false;
            $response['message'] = 'success';
            $response['data'] = null;
        } else {
            Ticket::find($request->ticket_id)->likes()->create([
                'user_id' => $user->id
            ]);

            $response['status'] = true;
            $response['message'] = 'success';
            $response['data'] = null;
        }

        return response()->json($response, 200);
    }

    public function update(Request $request, User $user)
    {
        $response = [];

        # validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'supply' => 'integer|required|min:10|max:10000',
            'location' => 'string|required',
            'geo' => 'json|required',
            'amount' => 'integer|required',
            'location' => 'string|required',
            'schedule' => 'date|required',
            'organizer' => 'string|required',
            'start' => 'date|required',
            'end' => 'date|required',
            'user_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = $validator->errors();
            $response['data'] = null;

            return response()->json($response, 200);
        }

        # get ticket or fail
        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket) {
            $response['status'] = false;
            $response['message'] = 'not existing';
            $response['data'] = null;

            return response()->json($response, 200);
        }

        # get authorization or creator
        if ($user->id != $ticket->user->id) {
            $response['status'] = false;
            $response['message'] = 'not authorized';
            $response['data'] = null;

            return response()->json($response, 200);
        }

        # update and confirm update
        $update = $ticket->update(
            [
                'supply' => $request->supply,
                'location' => $request->location,
                'geo' => $request->geo,
                'amount' => $request->amount,
                'host' => $request->host,
                'organizer' => $request->organizer,
                'start' => $request->start,
                'end' => $request->end,
            ]
        );
        if (!$update) {
            $response['status'] = false;
            $response['message'] = 'not updated';
            $response['data'] = null;

            return response()->json($response, 200);
        }

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = null;

        return response()->json($response, 200);
    }

    public function onPurchase(Request $request, String $id)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = $validator->errors();
            $response['data'] = null;

            return response()->json($response, 200);
        }

        # get ticket or fail
        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket) {
            $response['status'] = false;
            $response['message'] = 'not existing';
            $response['data'] = null;

            return response()->json($response, 200);
        }

        # reduce supply if it is not zero
        if ($ticket->supply > 0) {
            $ticket->update([
                'supply' => $ticket->supply - 1
            ]);
        }

        # start ticket generator
        NewTicketPurchasedEvent::dispatch([$ticket, User::find($id)]);

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $ticket;

        return response()->json($response, 200);
    }
}
