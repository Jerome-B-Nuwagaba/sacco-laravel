@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-gray-50 dark:bg-gray-900">
        <!-- Loan Analytics -->
        <h2 class="text-xl font-semibold mb-6 text-gray-800 dark:text-gray-100">Loan Analytics</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center shadow">
                <h3 class="font-bold text-lg text-gray-700 dark:text-gray-200">Today</h3>
                <p class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ $analytics['daily'] }}
                </p>
            </div>
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center shadow">
                <h3 class="font-bold text-lg text-gray-700 dark:text-gray-200">This Week</h3>
                <p class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ $analytics['weekly'] }}
                </p>
            </div>
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center shadow">
                <h3 class="font-bold text-lg text-gray-700 dark:text-gray-200">This Month</h3>
                <p class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ $analytics['monthly'] }}
                </p>
            </div>
        </div>
    </div>
@endsection
