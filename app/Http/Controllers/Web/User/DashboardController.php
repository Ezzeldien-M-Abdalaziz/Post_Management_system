<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.posts');
    }

    public function posts()
    {
        $user = Auth::user();
        $posts = $user->posts()->latest()->get();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'visibility' => 'required|boolean',
        ]);

        $request->user()->posts()->create($validated);

        return response()->json(['message' => 'Post created']);
    }

    public function update(Request $request, $id){
        $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id()) abort(403);

        $post->update($request->only('title', 'content', 'visibility'));
        return response()->json(['message' => 'Post updated']);
    }

    public function destroy($id)
    {
         $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id()) abort(403);

        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }

}
