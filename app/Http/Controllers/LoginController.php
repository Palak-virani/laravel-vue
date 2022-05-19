<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
    }
    public function register(Request $r)
    {

        $error = $r->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $create_satus = $this->user->create($r);
        // $token = $create_satus->createToken('LaravelAuthApp')->accessToken;


        return response()->json(['status' => $create_satus, 'error' => $error]);
    }

    public function login(Request $request)
    {

        $error = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($data)) {
            return response()->json(Auth::user(), 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 422);
        }
    }
}
