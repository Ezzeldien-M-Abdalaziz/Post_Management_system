
@extends('layouts.app')
@section('body')
    <main class="flex-grow flex items-center justify-center py-12">
      <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-8">
          <h1 class="text-2xl font-bold text-gray-900">Login to Your Account</h1>
          <p class="text-gray-600 mt-2">Enter your credentials to access your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if ($errors->any())
            <div class="mb-4 text-red-600">
              <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              type="email"
              id="email"
                name="email"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500"
              placeholder="your@email.com"
              required
            />
          </div>

          <div class="mb-6">
            <div class="flex items-center justify-between mb-1">
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            </div>
            <input
              type="password"
              id="password"
                name="password"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500"
              placeholder="••••••••"
              required
            />
          </div>

          <button
            type="submit"
            class="w-full bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 py-2"
          >
            Login
          </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
          Don't have an account?
          <a href="{{route('register.form')}}" class="font-medium text-brand-600 hover:text-brand-500">Sign up</a>
        </p>
      </div>
    </main>

@endsection

