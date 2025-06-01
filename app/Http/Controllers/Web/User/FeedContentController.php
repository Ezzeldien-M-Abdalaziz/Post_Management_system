<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedContentController extends Controller
{
    public function index()
    {
        return view(view: 'frontend.feedContent');
    }

    public function posts()
    {
        $posts = Post::with('user')
            ->where('visibility', true)
            ->where('user_id', '!=', Auth::id()) // Exclude posts by the authenticated user
            ->latest()
            ->get();
            return response()->json($posts);
    }
}
