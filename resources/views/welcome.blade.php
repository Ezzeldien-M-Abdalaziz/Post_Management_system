
@extends('layouts.app')

@section('body')

    <main>
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Manage Your Content
                <span class="block text-blue-200">Like a Pro</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Create, edit, and publish amazing content with our powerful post management platform.
                Streamline your workflow and boost your productivity.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register.form') }}" class="bg-white text-blue-600 hover:bg-gray-50 px-8 py-4 rounded-lg font-semibold text-lg transition-colors shadow-lg">
                Get Started Free
                </a>
            </div>
            </div>
        </div>
        </section>


            <!-- Stats Section -->
        <section class="py-10 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-blue-400 mb-2">50K+</div>
                <div class="text-gray-300">Posts Created</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-green-400 mb-2">10K+</div>
                <div class="text-gray-300">Active Users</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-purple-400 mb-2">99.9%</div>
                <div class="text-gray-300">Uptime</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-orange-400 mb-2">24/7</div>
                <div class="text-gray-300">Support</div>
            </div>
            </div>
        </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Everything you need to manage posts
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                From creation to publication, we've got all the tools you need to create amazing content.
            </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                <i data-lucide="edit-3" class="w-6 h-6 text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Rich Text Editor</h3>
                <p class="text-gray-600 leading-relaxed">
                Create beautiful content with our intuitive rich text editor. Add images, format text, and embed media seamlessly.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                <i data-lucide="users" class="w-6 h-6 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Team Collaboration</h3>
                <p class="text-gray-600 leading-relaxed">
                Work together with your team. Share drafts, leave comments, and manage permissions with ease.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                <i data-lucide="bar-chart-3" class="w-6 h-6 text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Analytics & Insights</h3>
                <p class="text-gray-600 leading-relaxed">
                Track your content performance with detailed analytics. Understand what works and optimize your strategy.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-6">
                <i data-lucide="settings" class="w-6 h-6 text-orange-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Automated Workflows</h3>
                <p class="text-gray-600 leading-relaxed">
                Set up automated publishing schedules and approval workflows to streamline your content process.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                <i data-lucide="search" class="w-6 h-6 text-red-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Advanced Search</h3>
                <p class="text-gray-600 leading-relaxed">
                Find any post instantly with our powerful search and filtering capabilities. Never lose track of your content.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                <i data-lucide="plus" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Template Library</h3>
                <p class="text-gray-600 leading-relaxed">
                Start with professional templates or create your own. Speed up content creation with reusable components.
                </p>
            </div>
            </div>
        </div>
        </section>



    </main>
@endsection



