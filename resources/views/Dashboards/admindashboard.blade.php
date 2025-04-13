@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <!-- Registered Loan Officers -->
    <div class="mb-10">
        <h2 class="text-xl font-semibold mb-3">Loan Officers</h2>
        @forelse ($loanOfficers as $officer)
            <div class="bg-white p-4 mb-3 rounded shadow">
                <p><strong>Name:</strong> {{ $officer->name }}</p>
                <p><strong>Email:</strong> {{ $officer->email }}</p>
                <p><strong>Company:</strong> {{ $officer->company->name }}</p>
            </div>
        @empty
            <p>No loan officers registered yet.</p>
        @endforelse
    </div>

    <!-- Registered Customers -->
    <div class="mb-10">
        <h2 class="text-xl font-semibold mb-3">Customers</h2>
        @forelse ($customers as $customer)
            <div class="bg-white p-4 mb-3 rounded shadow">
                <p><strong>Name:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Company:</strong> {{ $customer->company->name }}</p>
            </div>
        @empty
            <p>No customers registered yet.</p>
        @endforelse
    </div>

    <!-- Approve Forwarded Loans -->
    <div class="mb-10">
        <h2 class="text-xl font-semibold mb-3">Loans Awaiting Admin Approval</h2>
        @forelse ($forwardedLoans as $loan)
            <div class="bg-white p-4 mb-3 rounded shadow">
                <p><strong>Customer:</strong> {{ $loan->customer->name }}</p>
                <p><strong>Loan Type:</strong> {{ $loan->loanType->name }}</p>
                <p><strong>Amount:</strong> {{ $loan->amount }}</p>

                <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST" class="inline-block mr-2">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Approve</button>
                </form>
            </div>
        @empty
            <p>No forwarded loans available.</p>
        @endforelse
    </div>

    <!-- Add Loan Types -->
    <div class="mb-10">
        <h2 class="text-xl font-semibold mb-3">Add Loan Types</h2>
        <form action="{{ route('admin.loan-types.store') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-medium">Loan Type Name</label>
                <input type="text" name="name" id="name" class="w-full mt-1 rounded border-gray-300" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Loan Type</button>
        </form>
    </div>

    <!-- Loan Analytics -->
    <div>
        <h2 class="text-xl font-semibold mb-3">Loan Analytics</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-gray-100 p-4 rounded text-center shadow">
                <h3 class="font-bold text-lg">Today</h3>
                <p class="text-2xl">{{ $analytics['daily'] }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center shadow">
                <h3 class="font-bold text-lg">This Week</h3>
                <p class="text-2xl">{{ $analytics['weekly'] }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center shadow">
                <h3 class="font-bold text-lg">This Month</h3>
                <p class="text-2xl">{{ $analytics['monthly'] }}</p>
            </div>
        </div>
    </div>
</div>
@endsection