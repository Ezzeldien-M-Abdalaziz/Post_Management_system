<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){

        $fields = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]
        );

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'error' => 'Email or Password wrong'
            ], 401);
        }

        $token = $user->createToken($request['email'], ['user'])->plainTextToken;

        $response = [
            'user' => $user,
            'user_token' => $token
        ];

        return response($response, 201);
    }

    public function register(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|confirmed|min:8',
            ],
            [
                'name.required' => 'name is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]
        );

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        $token = $user->createToken($request['email'], ['user'])->plainTextToken;

        $response = [
            'user' => $user,
            'user_token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Logged out successfully'
        ]);
    }
}
