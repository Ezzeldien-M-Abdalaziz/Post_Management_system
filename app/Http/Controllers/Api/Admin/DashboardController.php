<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function posts()
    {
        $posts = Post::with('user')->paginate(9);
        return response()->json($posts);
    }

    public function getPostById($id)
    {
        $post = Post::with('user')->find($id);
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

        $post->update($validatedData);
        return response()->json(['message' => "Post updated"]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => "Post not found"], 404);
        }

        $post->delete();
        return response()->json(['message' => "Post deleted"]);
    }
}
