<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FundEase - Your Trusted Loan Partner in Uganda</title>
    <meta name="description" content="FundEase offers reliable and modern loan management solutions in Uganda. Streamline your loan processes, automate repayments, and enhance customer experience.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/logo.png" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .display {
            position: relative;
            background-image: url('/images/bg.png'); /* Replace with a relevant Ugandan landscape or financial district */
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .display::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Slightly darker overlay */
            z-index: 1;
        }
        .display > * {
            position: relative;
            z-index: 2;
        }
        .feature-icon {
            width: 56px; /* Increased size for better visibility */
            height: 56px;
            border-radius: 16px; /* More rounded icons */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
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
                    <div class="flex items-center space-x-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-600 transition-colors">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-8 py-3 rounded-full hover:bg-emerald-700 transition-colors shadow-lg font-medium">
                                    Get Started
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
                    Your Trusted Loan Partner in Uganda
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500">FundEase</span>
                </h1>
                <p class="text-xl text-gray-200 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Providing reliable and efficient loan management solutions to individuals and businesses across Uganda.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-8 py-4 rounded-full text-lg hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl font-medium">
                        Register with us
                    </a>
                    <a href="{{ route('about') }}" class="border-2 border-emerald-600 text-emerald-600 dark:border-emerald-400 dark:text-emerald-400 px-8 py-4 rounded-full text-lg hover:bg-emerald-50/50 dark:hover:bg-gray-800 transition-colors font-medium">
                        Learn More
                    </a>

                </div>
            </div>
        </section>

        <section id="features" class="bg-white dark:bg-gray-800 py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Key Features</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg">Empowering you with the tools for financial success.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="feature-icon bg-emerald-100 dark:bg-emerald-900">
                            <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Fast Approval</h3>
                        <p class="text-gray-600 dark:text-gray-300">Get quick decisions on your loan applications.</p>
                    </div>

                    <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="feature-icon bg-emerald-100 dark:bg-emerald-900">
                            <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 0 002 2v14a2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Flexible Terms</h3>
                        <p class="text-gray-600 dark:text-gray-300">Choose from a variety of repayment options.</p>
                    </div>

                    <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="feature-icon bg-emerald-100 dark:bg-emerald-900">
                            <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Easy Application</h3>
                        <p class="text-gray-600 dark:text-gray-300">Apply for a loan online in minutes.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-emerald-600 dark:bg-emerald-700 py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div class="text-white p-6 rounded-lg">
                        <div class="text-4xl font-bold mb-2">10,000+</div>
                        <div class="text-emerald-100">Happy Customers</div>
                    </div>
                    <div class="text-white p-6 rounded-lg">
                        <div class="text-4xl font-bold mb-2">50+</div>
                        <div class="text-emerald-100">Branches Across Uganda</div>
                    </div>
                    <div class="text-white p-6 rounded-lg">
                        <div class="text-4xl font-bold mb-2">24/7</div>
                        <div class="text-emerald-100">Online Support</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-white dark:bg-gray-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-3xl p-12 text-center shadow-xl">
                    <h2 class="text-3xl font-bold text-white mb-6">Ready to Get Started?</h2>
                    <p class="text-emerald-100 mb-8 text-lg max-w-2xl mx-auto">
                        Experience a seamless loan process with FundEase.  Apply online today and get the financial support you need.
                    </p>
                    <a href="{{ route('register') }}" class="inline-block bg-white text-emerald-600 px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-colors shadow-lg hover:shadow-xl">
                        Get a Loan
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
                    <p class="text-sm">Your trusted partner for financial solutions in Uganda.</p>
                </div>
                <div class="mb-8">
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Our Services</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Loan Products</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div class="mb-8">
                    <h4 class="text-white font-semibold mb-4">Helpful Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">FAQs</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Financial Tips</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="mb-8">
                    <h4 class="text-white font-semibold mb-4">Connect With Us</h4>
                    <ul class="flex space-x-4">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors text-sm">Facebook</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors text-sm">Twitter</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors text-sm">Instagram</a></li>
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
