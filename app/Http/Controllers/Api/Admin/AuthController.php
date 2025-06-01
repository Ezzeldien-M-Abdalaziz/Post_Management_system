<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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

        $admin = Admin::where('email', $fields['email'])->first();

        if (!$admin || !Hash::check($fields['password'], $admin->password)) {
            return response([
                'error' => 'Email or Password wrong'
            ], 401);
        }

        $token = $admin->createToken($request['email'], ['admin'])->plainTextToken;

        $response = [
            'admin' => $admin,
            'admin_token' => $token
        ];

        return response($response, 201);
    }

    public function register(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:admins,email',
                'password' => 'required|string|confirmed|min:8',
            ],
            [
                'name.required' => 'name is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]
        );

        $admin = Admin::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        $token = $admin->createToken($request['email'], ['admin'])->plainTextToken;

        $response = [
            'admin' => $admin,
            'admin_token' => $token
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
