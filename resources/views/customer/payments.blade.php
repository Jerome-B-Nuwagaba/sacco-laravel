@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-gray-50 dark:bg-gray-900">
        <!-- Accept Payment Plan -->
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Payment Plans</h2>

        @forelse ($paymentPlans as $plan)
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 mb-4 rounded-lg shadow-sm">
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

                @if (!$plan->accepted)
                <form action="{{ route('customer.payment-plans.accept', $plan->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button
                        type="submit"
                        class="bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700
                               text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2
                               focus:ring-green-400 transition"
                    >
                        Accept Plan
                    </button>
                </form>

                <div class="mb-4">
                <form action="{{ route('customer.rejectPlan', $plan->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700
                               text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2
                               focus:ring-green-400 transition">Reject</button>
    </form>
</div>
    @else
    <span class="badge bg-success">Accepted</span>
@endif
            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400">No payment plans yet.</p>
        @endforelse
    </div>
@endsection
