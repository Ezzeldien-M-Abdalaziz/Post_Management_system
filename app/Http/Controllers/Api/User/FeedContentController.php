<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedContentController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->where('visibility', true)
        ->whereNot('user_id', Auth::id())
        ->paginate(9);

        return response()->json($posts);
    }
}
