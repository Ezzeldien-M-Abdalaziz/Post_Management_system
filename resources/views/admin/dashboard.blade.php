<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PostHub - Post Management Platform</title>
    <meta name="description" content="The most powerful post management platform for content creators and teams." />
    <meta name="author" content="PostHub" />
    <meta property="og:title" content="PostHub - Post Management Platform" />
    <meta property="og:description" content="The most powerful post management platform for content creators and teams." />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 font-sans">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i data-lucide="edit-3" class="w-5 h-5 text-white"></i>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="ml-3 text-xl font-bold text-gray-900">PostHub</a>
                    </div>
                </div>

                <div class="md:flex items-center space-x-4">
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button class="text-gray-700 hover:text-blue-600 font-medium">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto p-6">
        <div id="postsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Posts will be injected here -->
        </div>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="mt-8 flex justify-center items-center space-x-2">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="postModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full relative mx-4">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-xl font-bold transition-colors">
                ×
            </button>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Post</h2>
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
                    Update Post
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Footer content remains the same -->
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        let currentPage = 1;

function loadPosts(page = 1) {
    currentPage = page;
    $.ajax({
        url: "{{ route('admin.dashboard.posts') }}",
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
                                <div class="text-xs space-y-1 text-gray-500 mt-auto">
                                    <p><span class="font-medium">Visibility:</span> <span class="${post.visibility == 1 ? 'text-green-600' : 'text-blue-600'}">${post.visibility == 1 ? 'Public' : 'Private'}</span></p>
                                    <p><span class="font-medium">Author:</span> ${post.user.name}</p>
                                    <p><span class="font-medium">Created:</span> ${new Date(post.created_at).toLocaleString()}</p>
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
        error: function(xhr) {
            console.error('Error loading posts:', xhr.responseText);
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

    // Initialize with first page
    $(document).ready(function() {
        loadPosts(1);
    });

        function openEditModal(id, title, content, visibility) {
            $('#postId').val(id);
            $('#title').val(title);
            $('#content').val(content);
            $('#visibility').val(visibility);
            $('#postModal').removeClass('hidden');
        }

        function closeModal() {
            $('#postModal').addClass('hidden');
        }

       // Handle edit form submission
        $('#postForm').on('submit', function(e) {
            e.preventDefault();

            let postId = $('#postId').val();
            let url = `/admin/dashboard/post/${postId}`;

            $.ajax({
                url: url,
                method: 'PUT',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    alert('Post updated successfully!');
                    closeModal();
                    loadPosts(currentPage); // Reload the current page instead of defaulting to 1
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Something went wrong.');
                }
            });
        });

        // Delete post
        // Delete post
        function deletePost(postId) {
            if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) return;

            $.ajax({
                url: `/admin/dashboard/post/${postId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    alert('Post deleted successfully.');
                    loadPosts(currentPage); // Reload the current page

                    // Optional: If the current page becomes empty, go to previous page
                    $.get("{{ route('admin.dashboard.posts') }}", { page: currentPage }, function(response) {
                        if (response.data.length === 0 && currentPage > 1) {
                            loadPosts(currentPage - 1);
                        }
                    });
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Failed to delete post.');
                }
            });
        }
    </script>
</body>
</html>
