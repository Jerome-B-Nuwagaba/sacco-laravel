@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">
        Welcome, {{ auth()->user()->name }}
    </h1>

    @if ($currentLoan && $currentLoan->paymentPlan && $currentLoan->paymentPlan->status === 'active')
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Current Loan Status
        </h2>
        <p class="text-gray-700 dark:text-gray-300">
            <strong>Loan Type:</strong> {{ $currentLoan->loanType->name }}
        </p>
        <p class="text-gray-700 dark:text-gray-300">
            <strong>Amount:</strong> UGX {{ number_format($currentLoan->amount) }}
        </p>
        <p class="text-gray-700 dark:text-gray-300">
            <strong>Status:</strong> {{ ucfirst($currentLoan->status) }}
        </p>

        @php
            $plan = $currentLoan->paymentPlan;
            $totalDue = $plan ? ($plan->amount_per_installment * $plan->number_of_installments)
                : $currentLoan->amount;
            $paid     = $currentLoan->payments->sum('amount');
            $progress = $totalDue > 0 ? ($paid / $totalDue) * 100 : 0;
        @endphp

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Repayment Progress
            </label>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mt-1">
                <div
                  class="bg-green-500 h-4 rounded-full"
                  style="width: {{ $progress }}%"
                ></div>
            </div>
            <p class="text-sm mt-1 text-gray-600 dark:text-gray-400">
                UGX {{ number_format($paid) }} of UGX {{ number_format($totalDue) }} paid
                ({{ number_format($progress, 1) }}%)
            </p>
        </div>
    </div>
@endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Active Payment Plans
        </h2>
        <ul>
            @foreach ($paymentPlans->where('status', 'active') as $plan)
                <li class="mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Completion Date:</strong> {{ $plan->completion_date->format('M d, Y') }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Amount:</strong> UGX {{ number_format($plan->amount_per_installment * $plan->number_of_installments) }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Status:</strong> {{ $plan->accepted ? 'Accepted' : 'Pending' }}
                    </p>
                </li>
            @endforeach
        </ul>
    </div>

@if ($paymentPlans->where('status', 'completed')->count() > 0)
<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
        Completed Payment Plans
    </h2>
    <ul>
        @foreach ($paymentPlans->where('status', 'completed') as $plan)
            <li class="mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Completion Date:</strong> {{ $plan->completion_date->format('M d, Y') }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Total Amount:</strong> UGX {{ number_format($plan->amount_per_installment * $plan->number_of_installments) }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Status:</strong> Completed
                </p>
            </li>
        @endforeach
    </ul>
</div>
@endif


    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Recent Activity
        </h2>
        @if (count($recentPayments) > 0)
            <ul>
                @foreach ($recentPayments as $payment)
                    <li class="mb-2 text-gray-700 dark:text-gray-300">
                        Paid UGX {{ number_format($payment->amount) }}
                        on {{ $payment->created_at->format('M d, Y') }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-700 dark:text-gray-300">No recent payments.</p>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Past Loans
        </h2>
        @if (count($pastLoans) > 0)
            <table class="w-full table-auto text-sm text-left text-gray-900 dark:text-gray-100">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pastLoans as $loan)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $loan->loanType->name }}</td>
                            <td class="px-4 py-2">
                                UGX {{ number_format($loan->amount) }}
                            </td>
                            <td class="px-4 py-2 capitalize">{{ $loan->status }}</td>
                            <td class="px-4 py-2">
                                {{ $loan->created_at?->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-700 dark:text-gray-300">No past loans available.</p>
        @endif
    </div>
</div>
@endsection
