<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <!-- Tailwind & Your JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body
    x-data="{
      darkMode: localStorage.getItem('darkMode') === 'true'
                 || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches),
      applyTheme() {
        document.documentElement.classList.toggle('dark', this.darkMode);
        localStorage.setItem('darkMode', this.darkMode);
      }
    }"
    x-init="applyTheme()"
    class="font-sans antialiased"
>
    <div class="flex h-screen bg-gray-200 ">
        {{-- Sidebar --}}
        @include('layouts.sidenav')

        {{-- Main Content Area --}}
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-800">
            @include('layouts.topnav')

            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
