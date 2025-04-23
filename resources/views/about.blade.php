<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About FundEase - Your Trusted Loan Partner in Uganda</title>
    <meta name="description" content="Learn more about FundEase, our mission, and how we provide reliable and modern loan management solutions to individuals and businesses across Uganda.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #10b981; /* Emerald */
            margin-bottom: 2rem;
            text-align: center;
        }
        .section-paragraph {
            font-size: 1.1rem;
            color: #4b5563; /* Gray */
            line-height: 1.75;
            margin-bottom: 2rem;
            text-align: center;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .feature-item {
            background-color: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .feature-item:hover {
            transform: translateY(-0.5rem);
            box-shadow: 0 6px 8px -1px rgba(0, 0, 0, 0.15), 0 4px 6px -1px rgba(0, 0, 0, 0.08);
        }
        .feature-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1f2937;
        }
        .process-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2rem;
        }
        .process-step-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: #fff;
            font-size: 1.5rem;
        }
        .process-step-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1f2937;
        }
        .perk-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .perk-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #fff;
        }
        .perk-text {
            font-size: 1.1rem;
            color: #374151;
        }
        .call-to-action {
            background-color: #10b981;
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 9999px;
            font-size: 1.25rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 2rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .call-to-action:hover {
            background-color: #059669;
            transform: translateY(-0.25rem);
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }
            .section-paragraph {
                font-size: 1rem;
            }
            .feature-item {
                margin-bottom: 2rem;
            }
            .perk-item {
                flex-direction: column;
                text-align: center;
            }
            .perk-icon {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 fixed w-full z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                <a href="/" class="mr-4">
                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors align-middle" style="font-size: 1.2em;">
                        home
                    </span>
                </a>
                    <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">FundEase</span>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-600 transition-colors">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-8 py-3 rounded-full hover:bg-emerald-700 transition-colors shadow-lg font-medium">
                                Get Started
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24">
        <section class="py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="section-title">About FundEase</h2>
                <p class="section-paragraph">
                    FundEase is a modern financial platform dedicated to providing accessible and reliable loan solutions in Uganda.  We leverage technology to streamline the loan process, offering fast approvals, flexible terms, and personalized service.  Our mission is to empower individuals and businesses to achieve their financial goals with ease and confidence.
                </p>
            </div>
        </section>

        <section class="bg-gray-50 dark:bg-gray-800 py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="section-title">Why Choose FundEase?</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="feature-item">
                        <div class="feature-icon bg-emerald-500 dark:bg-emerald-700">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <h3 class="feature-title">Fast Approval</h3>
                        <p class="text-gray-600 dark:text-gray-300">Get a decision on your loan application quickly.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon bg-blue-500 dark:bg-blue-700">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 0 00-2-2H7a2 0 002 2v14a2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="feature-title">Flexible Terms</h3>
                        <p class="text-gray-600 dark:text-gray-300">Choose a repayment plan that fits your needs.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon bg-green-500 dark:bg-green-700">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-8 4h.01M9 19h.01M12 15h1m-3 4h.01"/>
                            </svg>
                        </div>
                        <h3 class="feature-title">Easy Application</h3>
                        <p class="text-gray-600 dark:text-gray-300">Apply for a loan online in a few simple steps.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="section-title">Loan Application Process</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="process-step">
                        <div class="process-step-icon bg-blue-500 dark:bg-blue-700">1</div>
                        <h3 class="process-step-title">Apply Online</h3>
                        <p class="text-gray-600 dark:text-gray-300">Fill out our easy-to-use online application form.</p>
                    </div>
                    <div class="process-step">
                        <div class="process-step-icon bg-green-500 dark:bg-green-700">2</div>
                        <h3 class="process-step-title">Get Approved</h3>
                        <p class="text-gray-600 dark:text-gray-300">We'll review your application and notify you of our decision.</p>
                    </div>
                    <div class="process-step">
                        <div class="process-step-icon bg-emerald-500 dark:bg-emerald-700">3</div>
                        <h3 class="process-step-title">Receive Funds</h3>
                        <p class="text-gray-600 dark:text-gray-300">Once approved, you'll receive your funds quickly.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 dark:bg-gray-800 py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="section-title">Perks of Choosing FundEase</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="perk-item">
                        <div class="perk-icon bg-emerald-500 dark:bg-emerald-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11v2m4-2v2m4-2v2m-4-3.5V7a2.5 2.5 0 015 0v8.5a2.5 2.5 0 01-5 0v-8.5zM12 17h.01M20 10V18a2 2 0 01-2 2H6a2 2 0 01-2-2V10m12 0v1m-2-1h4m-4 3h4m2-3h-1m-1 0l-.5 5"/>
                            </svg>
                        </div>
                        <p class="perk-text">Competitive interest rates tailored to your financial situation.</p>
                    </div>
                    <div class="perk-item">
                        <div class="perk-icon bg-blue-500 dark:bg-blue-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h18M3 17h18m-9-4h4-4H12z"/>
                            </svg>
                        </div>
                        <p class="perk-text">Flexible repayment options to fit your budget.</p>
                    </div>
                    <div class="perk-item">
                        <div class="perk-icon bg-green-500 dark:bg-green-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 002 2v6a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <pclass="perk-text">Secure and transparent loan management process.</p>
                    </div>
                    <div class="perk-item">
                        <div class="perk-icon bg-yellow-500 dark:bg-yellow-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <p class="perk-text">Dedicated customer support to assist you every step of the way.</p>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="call-to-action">Get Started Today</a>
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