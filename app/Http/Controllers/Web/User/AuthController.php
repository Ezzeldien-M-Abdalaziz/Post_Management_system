<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user , true);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registration successful. Welcome!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],[
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',

        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard.index'));
        }

        // Redirect back with error
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
