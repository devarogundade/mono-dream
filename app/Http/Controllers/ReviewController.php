<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function create(Request $request, String $id) {
        $response = [];

        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = $validator->errors();
            $response['data'] = null;

            return response()->json($response, 200);
        }

        $ticket = Ticket::find($id);
        $review = $ticket->reviews()->create([
            'text' => $request->text,
            'user_id' => $request->user_id
        ]);

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $review;

        return response()->json($response, 200);
    }
}
