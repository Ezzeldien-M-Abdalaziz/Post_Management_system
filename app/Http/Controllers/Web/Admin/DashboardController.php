<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function posts(Request $request){
    $perPage = $request->input('per_page', 9); // Default to 10 items per page
    $posts = Post::with('user')
        ->latest()
        ->paginate($perPage);

    return response()->json($posts);
}

    public function update(Request $request, $id){
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json(['message' => 'Post updated successfully']);
    }
    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
