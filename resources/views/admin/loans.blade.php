@extends('layouts.app')

@section('content')
<!-- Success Message -->
@if (session('success'))
    <div class="bg-green-600 text-white p-4 mb-3 rounded">
        {{ session('success') }}
    </div>
@endif

<!-- Error Messages -->
@if ($errors->any())
    <div class="bg-red-600 text-white p-4 mb-3 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Approve Forwarded Loans -->
<div class="mb-10">
    <h2 class="text-xl font-semibold mb-3">Loans Awaiting Approval</h2>
    @forelse ($loans as $loan)
        <div class="bg-white p-4 mb-3 rounded shadow">
            <p><strong>Customer ID:</strong> {{ $loan->customer_id }}</p>
            <p><strong>Customer Name:</strong> {{ $loan->customer->name }}</p>
            <p><strong>Loan Type:</strong> {{ $loan->loanType->name}}</p>
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
    <div class="mb-4">
        <label for="lower_limit" class="block font-medium">Lower Limit</label>
        <input type="number" name="lower_limit" id="lower_limit" class="w-full mt-1 rounded border-gray-300" required>
    </div>
    <div class="mb-4">
        <label for="upper_limit" class="block font-medium">Upper Limit</label>
        <input type="number" name="upper_limit" id="upper_limit" class="w-full mt-1 rounded border-gray-300" required>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Loan Type</button>
</form>

</div>
@endsection