@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 space-y-8">

    {{-- Top Summary Cards --}}
    <div>
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Dashboard Overview</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 font-semibold">Total Users</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['users'] ?? 0 }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 font-semibold">Pending Requests</h3>
                <p class="text-3xl font-bold text-yellow-500">{{ $analytics['pending'] ?? 0 }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 font-semibold">Approved Loans</h3>
                <p class="text-3xl font-bold text-green-500">{{ $analytics['approved'] ?? 0 }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center">
                <h3 class="text-gray-600 font-semibold">Rejected Loans</h3>
                <p class="text-3xl font-bold text-red-500">{{ $analytics['rejected'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Loan Handled Summary --}}
    <div>
        <h2 class="text-xl font-semibold mb-3 text-gray-700">Loan Handled Summary</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl text-center shadow">
                <h3 class="font-semibold text-gray-600 mb-1">Today</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['daily'] ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl text-center shadow">
                <h3 class="font-semibold text-gray-600 mb-1">This Week</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['weekly'] ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl text-center shadow">
                <h3 class="font-semibold text-gray-600 mb-1">This Month</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['monthly'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Placeholder: Recent Activity Table --}}
    <div>
        <h2 class="text-xl font-semibold mb-3 text-gray-700">Recent Loan Applications</h2>
        <div class="bg-white shadow rounded-xl p-4 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b font-semibold text-gray-600">
                        <th class="px-4 py-2">Applicant</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLoans ?? [] as $loan)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $loan->user->name }}</td>
                            <td class="px-4 py-2">{{ $loan->amount }}</td>
                            <td class="px-4 py-2">{{ $loan->type }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $loan->status == 'approved' ? 'bg-green-100 text-green-700' : ($loan->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $loan->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No recent applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
