@extends('layouts.app')

@section('body')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">All Posts</h1>
    </div>

    <div id="postsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Posts will be injected here -->
    </div>
</div>
@endsection


@section('scripts')
<script>
 function loadPosts() {
  $.ajax({
    url: "{{ route('feed.posts') }}",
    method: 'GET',
    success: function (posts) {
      let html = '';
      if (posts.length === 0) {
        html = '<p class="text-gray-500">No posts found.</p>';
      } else {
        posts.forEach(function (post) {
          html += `
            <div class="bg-white p-4 rounded shadow relative group">
              <h2 class="text-lg font-semibold mb-2">${post.title}</h2>
              <p class="text-sm text-gray-600 mb-2">${post.content}</p>
              <p class="text-xs text-blue-500 mt-2">By: ${post.user?.name || 'Unknown User'} (ID: ${post.user?.id})</p>
            </div>`;
        });
      }
      $('#postsContainer').html(html);
    },
    error: function () {
      $('#postsContainer').html('<p class="text-red-500">Failed to load posts.</p>');
    }
  });
}


$(document).ready(function () {
  loadPosts();
});


</script>
@endsection
