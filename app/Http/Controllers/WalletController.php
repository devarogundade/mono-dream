<?php

namespace App\Http\Controllers;

use App\Models\User;

class WalletController extends Controller
{
    public function balance(String $id) {
        $response = [];

        $user = User::find($id);

        # get or create wallet
        $wallet = $user->wallet;
        if (!$wallet) {
            $wallet = $user->wallet();
        }

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $wallet;

        return response()->json($response, 200);
    }
}
