@extends('layouts.app')

@section('body')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Posts</h1>
        <button onclick="openModal('create')"
           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm flex items-center">
            <i data-lucide="plus" class="w-4 h-4 mr-1"></i> Create Post
        </button>
    </div>

    <div id="postsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Posts will be injected here -->
    </div>

    <!-- Pagination Controls -->
    <div id="paginationControls" class="mt-8 flex justify-center items-center space-x-2">
        <!-- Will be populated by JavaScript -->
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="postModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full relative mx-4">
    <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-xl font-bold transition-colors">
      ×
    </button>
    <h2 id="modalTitle" class="text-2xl font-bold text-gray-800 mb-4">Create New Post</h2>
    <form id="postForm">
      @csrf
      <input type="hidden" name="post_id" id="postId">
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" id="title" placeholder="Post title"
               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
        <textarea name="content" id="content" placeholder="Post content" rows="4"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required></textarea>
      </div>
      <div class="mb-6">
        <label for="visibility" class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
        <select name="visibility" id="visibility"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
          <option value="1">Public</option>
          <option value="0">Private</option>
        </select>
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Submit
      </button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
// Track current page
let currentPage = 1;

function loadPosts(page = 1) {
    currentPage = page;
    $.ajax({
        url: "{{ route('dashboard.posts') }}",
        method: 'GET',
        data: { page: page },
        success: function(response) {
            let html = '';
            if (response.data.length === 0) {
                html = '<div class="col-span-full text-center py-12"><p class="text-gray-500 text-lg">No posts found.</p></div>';
            } else {
                response.data.forEach(function(post) {
                    html += `
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                            <div class="p-5 flex-grow">
                                <h2 class="text-xl font-bold text-gray-800 mb-2">${post.title}</h2>
                                <p class="text-gray-600 mb-4">${post.content}</p>
                                <div class="text-xs space-y-1 text-gray-500">
                                    <p><span class="font-medium">Created:</span> ${new Date(post.created_at).toLocaleString()}</p>
                                    <p><span class="font-medium">Visibility:</span> <span class="${post.visibility == 1 ? 'text-green-600' : 'text-blue-600'}">${post.visibility == 1 ? 'Public' : 'Private'}</span></p>
                                </div>
                            </div>
                            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex justify-end space-x-2">
                                <button onclick="openEditModal(${post.id}, '${post.title.replace(/'/g, "\\'")}', '${post.content.replace(/'/g, "\\'")}', ${post.visibility})"
                                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                    Edit
                                </button>
                                <button onclick="deletePost(${post.id})"
                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>`;
                });
            }
            $('#postsContainer').html(html);
            updatePaginationControls(response);
            lucide.createIcons();
        },
        error: function() {
            $('#postsContainer').html('<div class="col-span-full text-center py-12"><p class="text-red-500 text-lg">Failed to load posts. Please try again.</p></div>');
        }
    });
}

function updatePaginationControls(response) {
    let paginationHtml = '';

    // Previous button
    paginationHtml += `<button onclick="loadPosts(${response.current_page - 1})"
        class="px-3 py-1 rounded-md ${response.current_page === 1 ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700'}"
        ${response.current_page === 1 ? 'disabled' : ''}>
        Previous
    </button>`;

    // Page numbers
    for (let i = 1; i <= response.last_page; i++) {
        paginationHtml += `<button onclick="loadPosts(${i})"
            class="px-3 py-1 rounded-md ${i === response.current_page ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}">
            ${i}
        </button>`;
    }

    // Next button
    paginationHtml += `<button onclick="loadPosts(${response.current_page + 1})"
        class="px-3 py-1 rounded-md ${response.current_page === response.last_page ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700'}"
        ${response.current_page === response.last_page ? 'disabled' : ''}>
        Next
    </button>`;

    $('#paginationControls').html(paginationHtml);
}

$(document).ready(function () {
    lucide.createIcons();
    loadPosts(1);
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
            loadPosts(currentPage);
        },
        error: function (xhr) {
            alert(xhr.responseJSON?.message || 'Something went wrong.');
        }
    });
});

// Delete post
function deletePost(postId) {
    if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) return;

    $.ajax({
        url: `/dashboard/post/${postId}`,
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}',
            page: currentPage
        },
        success: function (response) {
            alert('Post deleted successfully.');
            if (response.current_page < currentPage && currentPage > 1) {
                loadPosts(currentPage - 1);
            } else {
                loadPosts(currentPage);
            }
        },
        error: function (xhr) {
            alert(xhr.responseJSON?.message || 'Failed to delete post.');
        }
    });
}
</script>
@endsection
