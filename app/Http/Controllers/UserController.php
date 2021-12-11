<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function user(String $id) {
        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = User::find($id);

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = $validator->errors();
            $response['data'] = null;

            return response()->json($response, 200);
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $response['status'] = false;
            $response['message'] = 'user not found';
            $response['data'] = null;

            return response()->json($response, 200);
        }

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = Auth::user();


        return response()->json($response, 200);
    }

    public function register(Request $request)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = $validator->errors();
            $response['data'] = null;

            return response()->json($response, 200);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        # create user nft wallet
        $user->wallet()->create();

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $user;

        return response()->json($response, 200);
    }

    public function owned(String $id) {
        $response = [];

        $tickets = UserTicket::where('user_id', $id)->get();

        $response['status'] = true;
        $response['message'] = 'success';
        $response['data'] = $tickets;

        return response()->json($response, 200);
    }
}
