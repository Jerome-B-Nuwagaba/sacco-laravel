@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 space-y-8 bg-gray-50 dark:bg-gray-900">
    {{-- Top Summary Cards --}}
    <div>
        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Dashboard Overview</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold">Total Users</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $analytics['users'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold">Pending Requests</h3>
                <p class="text-3xl font-bold text-yellow-500 dark:text-yellow-400">{{ $analytics['pending'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold">Approved Loans</h3>
                <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $analytics['approved'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 dark:text-gray-400 font-semibold">Rejected Loans</h3>
                <p class="text-3xl font-bold text-red-500 dark:text-red-400">{{ $analytics['rejected'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Loan Handled Summary --}}
    <div>
        <h2 class="text-xl font-semibold mb-3 text-gray-700 dark:text-gray-200">Loan Handled Summary</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl text-center shadow">
                <h3 class="font-semibold text-gray-600 dark:text-gray-400 mb-1">Today</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $analytics['daily'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl text-center shadow">
                <h3 class="font-semibold text-gray-600 dark:text-gray-400 mb-1">This Week</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $analytics['weekly'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl text-center shadow">
                <h3 class="font-semibold text-gray-600 dark:text-gray-400 mb-1">This Month</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $analytics['monthly'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Recent Activity Table --}}
    <div>
        <h2 class="text-xl font-semibold mb-3 text-gray-700 dark:text-gray-200">Recent Loan Applications</h2>
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Applicant</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Amount</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Type</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Status</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLoans ?? [] as $loan)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $loan->user->name }}</td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ number_format($loan->amount) }}</td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $loan->type }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusClasses = [
                                        'approved' => 'bg-green-100 dark:bg-green-700 text-green-700 dark:text-green-200',
                                        'pending'  => 'bg-yellow-100 dark:bg-yellow-700 text-yellow-700 dark:text-yellow-200',
                                        'rejected' => 'bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-200',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $statusClasses[$loan->status] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $loan->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-600 dark:text-gray-400">
                                No recent applications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
