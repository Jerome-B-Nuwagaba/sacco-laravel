@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Welcome, {{ auth()->user()->name }}</h1>

    {{-- Current Loan Status --}}
    @if ($currentLoan)
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Current Loan Status</h2>
        <p><strong>Loan Type:</strong> {{ $currentLoan->loanType->name }}</p>
        <p><strong>Amount:</strong> UGX {{ number_format($currentLoan->amount) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($currentLoan->status) }}</p>

        {{-- Progress bar --}}
        @php
            $paid = $currentLoan->payments->sum('amount');
            $total = $currentLoan->amount;
            $progress = $total > 0 ? ($paid / $total) * 100 : 0;
        @endphp

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Repayment Progress</label>
            <div class="w-full bg-gray-200 rounded-full h-4 mt-1">
                <div class="bg-green-500 h-4 rounded-full" style="width: {{ $progress }}%"></div>
            </div>
            <p class="text-sm text-gray-600 mt-1">UGX {{ number_format($paid) }} of UGX {{ number_format($total) }} paid ({{ number_format($progress, 1) }}%)</p>
        </div>
    </div>
    @endif

    {{-- Active Payment Plans --}}
    @if (count($paymentPlans) > 0)
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Active Payment Plans</h2>
        <ul>
            @foreach ($paymentPlans as $plan)
                <li class="mb-3 border-b pb-2">
                    <p><strong>Due Date:</strong> {{ $plan->due_date->format('M d, Y') }}</p>
                    <p><strong>Amount:</strong> UGX {{ number_format($plan->amount) }}</p>
                    <p><strong>Status:</strong> {{ $plan->accepted ? 'Accepted' : 'Pending' }}</p>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Recent Activity --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
        @if (count($recentPayments) > 0)
            <ul>
                @foreach ($recentPayments as $payment)
                    <li class="mb-2">
                        Paid UGX {{ number_format($payment->amount) }} on {{ $payment->created_at->format('M d, Y') }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No recent payments.</p>
        @endif
    </div>

    {{-- Past Loans --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Past Loans</h2>
        @if (count($pastLoans) > 0)
            <table class="w-full table-auto text-sm text-left">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pastLoans as $loan)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $loan->loanType->name }}</td>
                            <td class="px-4 py-2">UGX {{ number_format($loan->amount) }}</td>
                            <td class="px-4 py-2 capitalize">{{ $loan->status }}</td>
                            <td class="px-4 py-2">{{ $loan->created_at ?->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No past loans available.</p>
        @endif
    </div>
</div>
@endsection
