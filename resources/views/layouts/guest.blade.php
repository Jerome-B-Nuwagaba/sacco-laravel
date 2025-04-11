<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        

        <title>Register with us</title>
        <link rel="icon" href="/images/logo.png" type="image/x-icon">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-green-50 dark:from-gray-900 dark:to-gray-800">
        <div class="min-h-screen flex flex-col items-center py-12 sm:py-24 px-4 sm:px-0">
           
            <!-- Form Container -->
            <div class="w-full sm:max-w-xl bg-white dark:bg-gray-800/50 backdrop-blur-lg shadow-xl rounded-2xl p-8 sm:p-12 border border-gray-100 dark:border-gray-700/50">
                 <!-- Logo Section -->
            <div class="mb-8 sm:mb-12 flex justify-center ">
                <a href="/" class="inline-block">
                    <img src="/images/logo.png" alt="Logo" class="h-20 w-auto hover:scale-105 transition-transform">
                </a>
            </div>

                {{ $slot }}
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center space-x-4">
                <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Privacy Policy</a>
                <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Terms of Service</a>
                <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Contact Support</a>
            </div>
        </div>
    </body>
</html>