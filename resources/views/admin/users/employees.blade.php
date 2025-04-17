@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-gray-50 dark:bg-gray-900">
        <!-- Registered Loan Officers -->
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
                Loan Officers
            </h2>

            @forelse ($loanOfficers as $officer)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 mb-3 rounded-lg shadow-sm">
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Name:</strong>
                        <span class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $officer->name }}
                        </span>
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Email:</strong>
                        <span class="font-medium text-blue-600 dark:text-blue-400">
                            {{ $officer->email }}
                        </span>
                    </p>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">
                    No loan officers registered yet.
                </p>
            @endforelse
        </div>
    </div>
@endsection
