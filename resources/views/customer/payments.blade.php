@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-gray-50 dark:bg-gray-900">
    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Payment Plans</h2>

    @forelse ($paymentPlans as $plan)
        {{-- Compute paid, total and remaining amounts --}}
        @php
            $paid = $plan->loan->payments->sum('amount');
            $totalDue = $plan->amount_per_installment * $plan->number_of_installments;
            $remaining = max($totalDue - $paid, 0);
        @endphp

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 mb-6 rounded-lg shadow-sm">
            {{-- Vertical details --}}
            <div class="space-y-3 mb-6">
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Installment Amount:</strong>
                    <span class="font-medium text-green-600 dark:text-green-400">
                        {{ number_format($plan->amount_per_installment, 2) }} UGX
                    </span>
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Number of Installments:</strong>
                    <span class="font-medium text-blue-600 dark:text-blue-400">
                        {{ $plan->number_of_installments }}
                    </span>
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Completion Date:</strong>
                    <span class="font-medium text-gray-800 dark:text-gray-200">
                        {{ \Carbon\Carbon::parse($plan->completion_date)->format('M d, Y') }}
                    </span>
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Total Due:</strong>
                    <span class="font-medium text-gray-900 dark:text-gray-100">
                        UGX {{ number_format($totalDue) }}
                    </span>
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Paid:</strong>
                    <span class="font-medium text-gray-900 dark:text-gray-100">
                        UGX {{ number_format($paid) }}
                    </span>
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Remaining:</strong>
                    <span class="font-medium text-red-600 dark:text-red-400">
                        UGX {{ number_format($remaining) }}
                    </span>
                </p>
                @if($plan->accepted)
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Status:</strong>
                        <span class="inline-block px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full font-semibold">
                            Accepted
                        </span>
                    </p>
                @endif
            </div>

            {{-- Actions: accept/reject or pay or complete notice --}}
            <div class="flex flex-wrap items-center gap-4">
                @if (! $plan->accepted)
                    <form action="{{ route('customer.payment-plans.accept', $plan->id) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700
                                   text-white font-semibold py-2 px-4 rounded-lg shadow transition"
                        >
                            Accept Plan
                        </button>
                    </form>

                    <form action="{{ route('customer.rejectPlan', $plan->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700
                                   text-white font-semibold py-2 px-4 rounded-lg shadow transition"
                        >
                            Reject Plan
                        </button>
                    </form>
                @elseif($remaining > 0)
                    <form action="{{ route('customer.loans.pay', $plan->loan->id) }}" method="POST" class="flex items-center space-x-2">
                        @csrf
                        <input type="hidden" name="loan_id" value="{{ $plan->loan->id }}">
                        <label for="amount-{{ $plan->id }}" class="sr-only">Amount</label>
                        <input
                            id="amount-{{ $plan->id }}"
                            type="number"
                            name="amount"
                            step="1"
                            min="1"
                            max="{{ $remaining }}"
                            value="{{ min($plan->amount_per_installment, $remaining) }}"
                            class="w-32 px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600"
                            required
                        />

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800
                                   text-white font-semibold py-2 px-4 rounded-lg shadow transition"
                        >
                            Pay Installment
                        </button>
                    </form>
                @else
                    <span class="text-green-600 font-semibold">Payment Complete</span>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-600 dark:text-gray-400">No payment plans yet.</p>
    @endforelse
</div>
@endsection
