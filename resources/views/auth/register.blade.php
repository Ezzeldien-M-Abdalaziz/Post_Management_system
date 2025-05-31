@extends('layouts.app')
@section('body')


<main class="flex-grow flex items-center justify-center py-12">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Create an Account</h1>
        <p class="text-gray-600 mt-2">Join ReserveEasy to book services</p>
      </div>

      <form method="POST" action="{{ route('register') }}">
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
        <div class="mb-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Name"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500"
              required
            />
          </div>

        </div>

        <div class="mb-4">
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


        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500"
            placeholder="••••••••"
            required
          />
        </div>

        <div class="mb-6">
          <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
          <input
            type="password"
            id="confirm-password"
            name="password_confirmation"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500"
            placeholder="••••••••"
            required
          />
        </div>

        <div class="flex items-center mb-6">
          <input type="checkbox" id="terms" class="h-4 w-4 text-brand-600 border-gray-300 rounded" required />
          <label for="terms" class="ml-2 block text-sm text-gray-700">
            I agree to the <a href="#" class="text-brand-600 hover:text-brand-500">Terms of Service</a> and <a href="#" class="text-brand-600 hover:text-brand-500">Privacy Policy</a>
          </label>
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 py-2"
        >
          Create Account
        </button>
      </form>

      <p class="mt-6 text-center text-sm text-gray-600">
        Already have an account?
        <a href="{{route('login.form')}}" class="font-medium text-brand-600 hover:text-brand-500">Login</a>
      </p>
    </div>
  </main>
@endsection
