@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Customer Dashboard</h1>

    <!-- Apply for Loan -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Apply for a Loan</h2>
        <form action="{{ route('customer.dashboard') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block font-medium">Loan Amount</label>
                <input type="number" name="amount" id="amount" class="w-full border-gray-300 rounded-md mt-1" required>
            </div>

            <div class="mb-4">
                <label for="loan_type_id" class="block font-medium">Loan Type</label>
                <select name="loan_type_id" id="loan_type_id" class="w-full border-gray-300 rounded-md mt-1" required>
                    <option value="">Select Loan Type</option>
                    @foreach ($loanTypes as $loanType)
                        <option value="{{ $loanType->id }}">{{ $loanType->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Apply</button>
        </form>
    </div>

    <!-- Active Loans / Payment -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">My Loans</h2>
        @forelse ($loans as $loan)
            <div class="bg-gray-100 p-4 mb-3 rounded">
                <p><strong>Type:</strong> {{ $loan->loanType->name }}</p>
                <p><strong>Amount:</strong> {{ $loan->amount }}</p>
                <p><strong>Status:</strong> {{ ucfirst($loan->status) }}</p>

                @if ($loan->status === 'approved')
                    <form action="{{ route('customer.loans.pay', $loan->id) }}" method="POST" class="mt-2">
                        @csrf
                        <input type="number" name="payment_amount" placeholder="Enter payment amount" class="border rounded w-full mt-1 mb-2 p-2" required>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Pay</button>
                    </form>
                @endif
            </div>
        @empty
            <p>No loan applications yet.</p>
        @endforelse
    </div>

    <!-- Accept Payment Plan -->
    <div>
        <h2 class="text-xl font-semibold mb-2">Payment Plans</h2>
        @forelse ($paymentPlans as $plan)
            <div class="bg-white p-4 border mb-4 rounded">
                <p><strong>Installment Amount:</strong> {{ $plan->amount_per_installment }}</p>
                <p><strong>Number of Installments:</strong> {{ $plan->number_of_installments }}</p>
                <p><strong>Completion Date:</strong> {{ $plan->completion_date }}</p>
                <form action="{{ route('customer.payment-plans.accept', $plan->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept Plan</button>
                </form>
            </div>
        @empty
            <p>No payment plans yet.</p>
        @endforelse
    </div>
</div>
@endsection