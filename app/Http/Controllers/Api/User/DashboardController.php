<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function posts()
    {
        $posts = Post::with('user')
        ->where('user_id', Auth::id())
        ->paginate(9);
        return response()->json($posts);
    }

    public function getPostById($id)
    {
        $post = Post::with('user')->find($id);
        // Ensure the post belongs to the authenticated user
        if ($post && $post->user_id !== Auth::id()) {
            return response()->json(['message' => "You do not have permission to view this post"], 403);
        }
        if (!$post) {
            return response()->json(['message' => "Post not found"], 404);
        }
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|boolean',
        ]);

        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => "Post not found"], 404);
        }

        // Ensure the post belongs to the authenticated user
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => "You do not have permission to update this post"], 403);
        }

        $post->update($validatedData);
        return response()->json(['message' => "Post updated"]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => "Post not found"], 404);
        }

        // Ensure the post belongs to the authenticated user
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => "You do not have permission to delete this post"], 403);
        }

        $post->delete();
        return response()->json(['message' => "Post deleted"]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|boolean',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'visibility' => $validatedData['visibility'],
        ]);

        return response()->json(['message' => "Post created", 'post' => $post], 201);
    }

}
