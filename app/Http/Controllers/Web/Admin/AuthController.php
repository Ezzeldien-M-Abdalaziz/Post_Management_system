<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function loginForm()
    {
        return view('admin.login');
    }

    public function Adminlogin(Request $request)
    {
       $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],[
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',

        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function adminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout successful.');
    }
}
