<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
         // Get the currently authenticated user
        $user = Auth::user();

        $posts = $user->posts()->latest()->paginate(9);
        return view('frontend.dashboard', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'visibility' => 'required|boolean',
        ]);

        $user = Auth::user();
        $user->posts()->create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'visibility' => $request->input('visibility'),
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Post created successfully.');
    }

    public function edit($postId)
    {
        $user = Auth::user();
        $post = $user->posts()->findOrFail($postId);

        return view('frontend.edit-post', compact('post'));
    }


    public function update(Request $request, $postId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'visibility' => 'required|boolean',
        ]);

        $user = Auth::user();
        $post = $user->posts()->findOrFail($postId);

        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'visibility' => $request->input('visibility'),
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($postId)
    {
        $user = Auth::user();
        $post = $user->posts()->findOrFail($postId);
        $post->delete();

        return redirect()->route('dashboard.index')->with('success', 'Post deleted successfully.');
    }

}
