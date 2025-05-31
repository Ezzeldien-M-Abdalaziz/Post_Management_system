<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        if(Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('welcome');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }


}
