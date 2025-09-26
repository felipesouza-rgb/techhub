{{-- resources/views/layouts/app.blade.php (layout base do componente AppLayout) --}}
@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' | ' : '' }}{{ config('app.name','Laravel') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen">
      <nav class="bg-white border-b shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-4">
          <a class="font-semibold">TechHub</a>
          <a href="{{ route('companies.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Companies</a>
          <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Projects</a>
          <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Users</a>
          <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</a>

          <div class="ml-auto flex items-center gap-3">
            @auth
              <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
              <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="text-sm text-red-600">Logout</button>
              </form>
            @endauth
            @guest
              <a href="{{ route('login') }}" class="text-sm text-indigo-600">Login</a>
            @endguest
          </div>
        </div>
      </nav>

      <main class="py-6">
        <div class="max-w-7xl mx-auto px-4">
          {{ $slot }}
        </div>
      </main>
    </div>
  </body>
</html>
