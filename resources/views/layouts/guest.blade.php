{{-- resources/views/layouts/guest.blade.php --}}
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
    <div class="min-h-screen flex items-center justify-center">
      <div class="w-full max-w-md bg-white shadow rounded p-6">
        {{ $slot }}
      </div>
    </div>
  </body>
</html>
