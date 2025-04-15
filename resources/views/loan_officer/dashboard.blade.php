@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Loan Officer Dashboard</h1>

    <!-- Registered Customers -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Registered Customers</h2>
        @forelse ($customers as $customer)
            <div class="bg-gray-100 p-4 mb-3 rounded">
                <p><strong>Name:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Company:</strong> {{ $customer->company->name }}</p>

                <a href="{{ route('loan_officer.loans.pending') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Review Loans</a>
            </div>
        @empty
            <p>No customers registered yet.</p>
        @endforelse
    </div>

    <!-- Review Pending Loans -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Pending Loan Applications</h2>
        @forelse ($pendingLoans as $loan)
            <div class="bg-white p-4 mb-3 rounded border">
                <p><strong>Customer:</strong> {{ $loan->customer->name }}</p>
                <p><strong>Amount:</strong> {{ $loan->amount }}</p>
                <p><strong>Loan Type:</strong> {{ $loan->loanType->name }}</p>

                <!-- Accept Loan -->
                <form action="{{ route('loan_officer.loans.update', $loan->id) }}" method="POST" class="inline-block mr-2">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Accept Loan</button>
                </form>

                <!-- Decline Loan -->
                <form action="{{ route('loan_officer.loans.update', $loan->id) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Decline Loan</button>
                </form>
            </div>
        @empty
            <p>No pending loans.</p>
        @endforelse
    </div>

    <!-- Paid Loans -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Paid Loans</h2>
        @forelse ($paidLoans as $loan)
            <div class="bg-gray-100 p-4 mb-3 rounded">
                <p><strong>Customer:</strong> {{ $loan->customer->name }}</p>
                <p><strong>Amount Paid:</strong> {{ $loan->amount }}</p>
                <p><strong>Loan Type:</strong> {{ $loan->loanType->name }}</p>
            </div>
        @empty
            <p>No paid loans yet.</p>
        @endforelse
    </div>

    <!-- Create Payment Plan -->
    <div>
        <h2 class="text-xl font-semibold mb-2">Create Payment Plan</h2>
        <form action="{{ route('loan_officer.payment_plan.store') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="loan_id" class="block font-medium">Select Loan</label>
                <select name="loan_id" id="loan_id" class="w-full border-gray-300 rounded-md mt-1" required>
                    <option value="">Select Loan</option>
                    @foreach ($pendingLoans as $loan)
                        <option value="{{ $loan->id }}">{{ $loan->customer->name }} - {{ $loan->amount }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="amount_per_installment" class="block font-medium">Amount per Installment</label>
                <input type="number" name="amount_per_installment" id="amount_per_installment" class="w-full border-gray-300 rounded-md mt-1" required>
            </div>

            <div class="mb-4">
                <label for="number_of_installments" class="block font-medium">Number of Installments</label>
                <input type="number" name="number_of_installments" id="number_of_installments" class="w-full border-gray-300 rounded-md mt-1" required>
            </div>

            <div class="mb-4">
                <label for="completion_date" class="block font-medium">Completion Date</label>
                <input type="date" name="completion_date" id="completion_date" class="w-full border-gray-300 rounded-md mt-1" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Payment Plan</button>
        </form>
    </div>
</div>
@endsection