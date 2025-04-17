@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-gray-50 dark:bg-gray-900">
        <!-- Registered Customers -->
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">Customers</h2>

            @forelse ($customers as $customer)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 mb-3 rounded-lg shadow-sm">
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Name:</strong>
                        <span class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $customer->name }}
                        </span>
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Email:</strong>
                        <span class="font-medium text-blue-600 dark:text-blue-400">
                            {{ $customer->email }}
                        </span>
                    </p>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">No customers registered yet.</p>
            @endforelse
        </div>
    </div>
@endsection
