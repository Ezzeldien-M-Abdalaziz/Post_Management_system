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
              <a href="{{ route('home') }}" class="ml-3 text-xl font-bold text-gray-900">PostHub</a>
            </div>
          </div>

          <!-- Desktop Navigation -->
          <nav class="hidden md:flex space-x-8">
            <a href="{{ route('dashboard.index') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Dashboard</a>
            <a href="{{ route('feed.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Feed</a>
          </nav>

          <!-- Desktop CTA -->
          <div class="hidden md:flex items-center space-x-4">


               @if (Auth::check())
              <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="text-gray-700 hover:text-brand-500">Logout</button>
                </form>
              @elseif (Route::has('login.form'))
              <a href="{{ route('login.form') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-base font-medium transition-colors">
                login
              </a>
              @endif
          </div>

          <!-- Mobile menu button -->
          <div class="md:hidden">
            <button
              onclick="toggleMobileMenu()"
              class="text-gray-500 hover:text-gray-700 p-2"
              id="mobile-menu-button"
            >
              <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
              <i data-lucide="x" class="w-6 h-6 hidden" id="close-icon"></i>
            </button>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden border-t bg-white hidden" id="mobile-menu">
          <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="#" class="text-gray-900 block px-3 py-2 text-base font-medium">Dashboard</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 block px-3 py-2 text-base font-medium">Posts</a>
            <div class="pt-2">
              <a href="{{ route('login.form') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-base font-medium transition-colors">
                login
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    @section('scripts')
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Mobile menu toggle function
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }
        </script>

    @endsection
