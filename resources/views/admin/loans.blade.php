@extends('layouts.app')

@section('content')
<!-- Success Message -->
@if (session('success'))
    <div class="bg-green-600 text-white p-4 mb-3 rounded dark:bg-green-500 dark:text-white">
        {{ session('success') }}
    </div>
@endif

<!-- Error Messages -->
@if ($errors->any())
    <div class="bg-red-600 text-white p-4 mb-3 rounded dark:bg-red-500 dark:text-white">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Approve Forwarded Loans -->
<div class="mb-10">
    <h2 class="text-xl font-semibold mb-3 text-gray-800 dark:text-gray-100">Loans Awaiting Approval</h2>
    @forelse ($loans as $loan)
        <div class="bg-white dark:bg-gray-800 p-4 mb-3 rounded shadow dark:shadow-md">
            <p class="text-gray-700 dark:text-gray-300"><strong>Customer ID:</strong> {{ $loan->customer_id }}</p>
            <p class="text-gray-700 dark:text-gray-300"><strong>Customer Name:</strong> {{ $loan->customer->name }}</p>
            <p class="text-gray-700 dark:text-gray-300"><strong>Loan Type:</strong> {{ $loan->loanType->name }}</p>
            <p class="text-gray-700 dark:text-gray-300"><strong>Amount:</strong> {{ $loan->amount }}</p>

            <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST" class="inline-block mr-2">
                @csrf
                <button type="submit" class="bg-green-600 dark:bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 dark:hover:bg-green-600">
                    Approve
                </button>
            </form>
        </div>
    @empty
        <p class="text-gray-700 dark:text-gray-300">No forwarded loans available.</p>
    @endforelse
</div>

<!-- Add Loan Types -->
<div class="mb-10">
    <h2 class="text-xl font-semibold mb-3 text-gray-800 dark:text-gray-100">Add Loan Types</h2>
    <form action="{{ route('admin.loan-types.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-4 rounded shadow dark:shadow-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-800 dark:text-gray-100">Loan Type Name</label>
            <input type="text" name="name" id="name" class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label for="lower_limit" class="block font-medium text-gray-800 dark:text-gray-100">Lower Limit</label>
            <input type="number" name="lower_limit" id="lower_limit" class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label for="upper_limit" class="block font-medium text-gray-800 dark:text-gray-100">Upper Limit</label>
            <input type="number" name="upper_limit" id="upper_limit" class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
        </div>
        <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600">
            Add Loan Type
        </button>
    </form>
</div>
@endsection
