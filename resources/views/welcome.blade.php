<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FundEase - Modern Loan Management Platform</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />
    <link rel="icon" href="/images/logo.png" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .display {
            position: relative; 
            background-image: url('/images/bg.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
/*creating an overlay to make bg image darker */
        .display::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); 
            z-index: 1; /* Ensure the overlay is on top of the background image */
        }

        .display > * {
            position: relative; /* Bring the content above the overlay */
            z-index: 2;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
    <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 fixed w-full z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">FundEase</span>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center space-x-8">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-600 transition-colors">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-6 py-2 rounded-full hover:bg-emerald-700 transition-colors shadow-lg">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24">
        <section class="display mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-28">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                    Simplify Your Loan Management with
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500">FundEase</span>
                </h1>
                <p class="text-xl text-gray-200 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Streamline loan processing, automate repayments, and enhance customer experience with our intelligent platform.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-8 py-4 rounded-full text-lg hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl">
                        Sign Up
                    </a>
                    <a href="#features" class="border-2 border-emerald-600 text-emerald-600 dark:border-emerald-400 dark:text-emerald-400 px-8 py-4 rounded-full text-lg hover:bg-emerald-50/50 dark:hover:bg-gray-800 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </section>

        <section id="features" class="bg-white dark:bg-gray-800 py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Powerful Features for Modern Lending</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg">Everything you need to manage loans efficiently and effectively</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Automated Processing</h3>
                        <p class="text-gray-600 dark:text-gray-300">AI-powered loan approval workflows and document processing</p>
                    </div>

                    <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 002 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Smart Tracking</h3>
                        <p class="text-gray-600 dark:text-gray-300">Real-time loan tracking with automated repayment reminders</p>
                    </div>

                    <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Flexible Payments</h3>
                        <p class="text-gray-600 dark:text-gray-300">Multiple payment options with automatic reconciliation</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-emerald-600 dark:bg-emerald-700 py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div class="text-white p-6">
                        <div class="text-4xl font-bold mb-2">15K+</div>
                        <div class="text-emerald-100">Loans Processed</div>
                    </div>
                    <div class="text-white p-6">
                        <div class="text-4xl font-bold mb-2">$4B+</div>
                        <div class="text-emerald-100">Managed Assets</div>
                    </div>
                    <div class="text-white p-6">
                        <div class="text-4xl font-bold mb-2">99.9%</div>
                        <div class="text-emerald-100">Uptime Guarantee</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-white dark:bg-gray-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-3xl p-12 text-center">
                    <h2 class="text-3xl font-bold text-white mb-6">Ready to Transform Your Loan Management?</h2>
                    <p class="text-emerald-100 mb-8 text-lg max-w-2xl mx-auto">Join hundreds of financial institutions already streamlining their operations with FundEase</p>
                    <a href="{{ route('register') }}" class="inline-block bg-white text-emerald-600 px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-colors shadow-lg">
                        Get Started Now
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="mb-8">
                    <h3 class="text-white font-semibold mb-4">FundEase</h3>
                    <p class="text-sm">Empowering financial institutions with modern lending solutions</p>
                </div>
                <div class="mb-8">
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Security</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Pricing</a></li>
                    </ul>
                </div>
                <div class="mb-8">
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Careers</a></li>
                    </ul>
                </div>
                <div class="mb-8">
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Privacy</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Terms</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-sm">
                &copy; {{ date('Y') }} FundEase. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>