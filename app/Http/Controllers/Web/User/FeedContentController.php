<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedContentController extends Controller
{
    public function index()
    {

        return view(view: 'frontend.feedContent');
    }
}
