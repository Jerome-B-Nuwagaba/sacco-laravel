@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 space-y-8 bg-gradient-to-br from-gray-100 to-gray-200 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 rounded-lg shadow-xl">
    {{-- Top Summary Cards with Icons and Hover Effects --}}
    <div>
        <h2 class="text-3xl font-extrabold mb-6 text-gray-800 dark:text-gray-100 animate-pulse">
            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Overview
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex flex-col justify-center items-center">
                <i class="fas fa-users text-indigo-500 text-4xl mb-3 animate-bounce"></i>
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold text-lg">Total Users</h3>
                <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ $analytics['users'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex flex-col justify-center items-center">
                <i class="fas fa-hourglass-half text-yellow-500 text-4xl mb-3 animate-pulse delay-100"></i>
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold text-lg">Pending Requests</h3>
                <p class="text-4xl font-bold text-yellow-500 dark:text-yellow-400">{{ $analytics['pending'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex flex-col justify-center items-center">
                <i class="fas fa-check-circle text-green-500 text-4xl mb-3 animate-bounce delay-200"></i>
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold text-lg">Approved Loans</h3>
                <p class="text-4xl font-bold text-green-500 dark:text-green-400">{{ $analytics['approved'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex flex-col justify-center items-center">
                <i class="fas fa-times-circle text-red-500 text-4xl mb-3 animate-pulse delay-300"></i>
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold text-lg">Rejected Loans</h3>
                <p class="text-4xl font-bold text-red-500 dark:text-red-400">{{ $analytics['rejected'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Loan Handled Summary with Subtle Backgrounds --}}
    <div>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200"><i class="fas fa-tasks mr-2"></i> Loan Handled Summary</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-indigo-100 dark:bg-indigo-900 bg-opacity-50 dark:bg-opacity-50 p-6 rounded-lg shadow-sm text-center hover:shadow-md transition-shadow duration-200">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-1"><i class="fas fa-sun text-yellow-400 mr-1"></i> Today</h3>
                <p class="text-3xl font-bold text-indigo-700 dark:text-indigo-300">{{ $analytics['daily'] ?? 0 }}</p>
            </div>
            <div class="bg-blue-100 dark:bg-blue-900 bg-opacity-50 dark:bg-opacity-50 p-6 rounded-lg shadow-sm text-center hover:shadow-md transition-shadow duration-200">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-1"><i class="fas fa-calendar-week text-green-400 mr-1"></i> This Week</h3>
                <p class="text-3xl font-bold text-blue-700 dark:text-blue-300">{{ $analytics['weekly'] ?? 0 }}</p>
            </div>
            <div class="bg-teal-100 dark:bg-teal-900 bg-opacity-50 dark:bg-opacity-50 p-6 rounded-lg shadow-sm text-center hover:shadow-md transition-shadow duration-200">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-1"><i class="fas fa-calendar-alt text-purple-400 mr-1"></i> This Month</h3>
                <p class="text-3xl font-bold text-teal-700 dark:text-teal-300">{{ $analytics['monthly'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Fun Fact/Quote Section --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-3 text-gray-700 dark:text-gray-200"><i class="fas fa-lightbulb mr-2"></i> Did You Know?</h2>
        @php
            $facts = [
                "Processing loans efficiently keeps customers happy and the economy moving!",
                "Every rejected loan is a learning opportunity to refine our criteria.",
                "A high approval rate can indicate effective risk assessment.",
                "Tracking user growth helps us understand our platform's impact.",
                "Staying on top of pending requests ensures timely service.",
            ];
            $randomFact = $facts[array_rand($facts)];
        @endphp
        <p class="text-gray-600 dark:text-gray-400 italic">{{ $randomFact }}</p>
    </div>
</div>
@endsection