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

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  </head>

<body class="min-h-screen bg-gray-50">

    @include('layouts.header')
        @if (session('success'))
        <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-200 rounded">
            {{ session('error') }}
        </div>
    @endif
    @yield('body')

    @include('layouts.footer')


    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @yield('scripts')

  </body>
</html>
