@extends('layouts.app')

@section('body')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">My Posts</h1>
        <a href="#" onclick="openModal('create')"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + Create Post
        </a>
    </div>

    <div id="postsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Posts will be injected here -->
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="postModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded shadow max-w-md w-full relative">
    <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
    <h2 id="modalTitle" class="text-xl font-bold mb-4">Create New Post</h2>
    <form id="postForm">
      @csrf
      <input type="hidden" name="post_id" id="postId">
      <input type="text" name="title" id="title" placeholder="Title" class="w-full border p-2 mb-3 rounded" required>
      <textarea name="content" id="content" placeholder="Content" class="w-full border p-2 mb-3 rounded" required></textarea>
      <select name="visibility" id="visibility" class="w-full border p-2 mb-3 rounded" required>
        <option value="1">Public</option>
        <option value="0">Private</option>
      </select>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Submit</button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
function loadPosts() {
  $.ajax({
    url: "{{ route('dashboard.posts') }}",
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
              <p class="text-xs text-gray-500 mb-4">
                Visibility: <strong>${post.visibility == 1 ? 'Public' : 'Private'}</strong>
              </p>
              <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                <button onclick="openEditModal(${post.id}, \`${post.title}\`, \`${post.content}\`, ${post.visibility})"
                  class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                <button onclick="deletePost(${post.id})"
                  class="text-red-600 hover:text-red-800 text-sm">Delete</button>
              </div>
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

// Open modal for create
function openModal(mode = 'create') {
  $('#postForm')[0].reset();
  $('#postId').val('');
  $('#modalTitle').text(mode === 'create' ? 'Create New Post' : 'Edit Post');
  $('#postModal').removeClass('hidden');
}

// Open modal for edit
function openEditModal(id, title, content, visibility) {
  $('#postId').val(id);
  $('#title').val(title);
  $('#content').val(content);
  $('#visibility').val(visibility);
  $('#modalTitle').text('Edit Post');
  $('#postModal').removeClass('hidden');
}

function closeModal() {
  $('#postModal').addClass('hidden');
}

// Handle create/edit form submission
$('#postForm').on('submit', function (e) {
  e.preventDefault();

  let postId = $('#postId').val();
  let url = postId ? `/dashboard/post/${postId}` : '/dashboard/post/store';
  let method = postId ? 'PUT' : 'POST';

  $.ajax({
    url: url,
    method: method,
    data: $(this).serialize(),
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    success: function () {
      alert(postId ? 'Post updated successfully!' : 'Post created successfully!');
      closeModal();
      loadPosts();
    },
    error: function () {
      alert('Something went wrong.');
    }
  });
});

// Delete post
function deletePost(postId) {
  if (!confirm('Are you sure you want to delete this post?')) return;

  $.ajax({
    url: `/dashboard/post/${postId}`,
    method: 'DELETE',
    data: { _token: '{{ csrf_token() }}' },
    success: function () {
      alert('Post deleted successfully.');
      loadPosts();
    },
    error: function () {
      alert('Failed to delete post.');
    }
  });
}
</script>
@endsection
