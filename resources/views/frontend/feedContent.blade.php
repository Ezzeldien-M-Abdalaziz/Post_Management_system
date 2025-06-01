@extends('layouts.app')

@section('body')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">All Posts</h1>
    </div>

    <div id="postsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Posts will be injected here -->
    </div>

    <!-- Pagination Controls -->
    <div id="paginationControls" class="mt-8 flex justify-center items-center space-x-2">
        <!-- Will be populated by JavaScript -->
    </div>
</div>
@endsection

@section('scripts')
<script>

let currentPage = 1;

function loadPosts(page = 1) {
    currentPage = page;
    $.ajax({
        url: "{{ route('feed.posts') }}",
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
                                    <p class="text-blue-500">
                                        By: ${post.user.name}
                                    </p>
                                </div>
                            </div>
                        </div>`;
                });
            }
            $('#postsContainer').html(html);
            updatePaginationControls(response);
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

// Initialize with first page
$(document).ready(function() {
    lucide.createIcons();
    loadPosts(1);
});
</script>
@endsection
