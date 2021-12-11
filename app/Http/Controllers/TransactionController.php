<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function history(String $id) {
        $response = [];

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = User::find($id)->transactions;

        return response()->json($response, 200);
    }
}
