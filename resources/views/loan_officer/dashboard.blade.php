@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Loan Officer Dashboard</h1>

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">Registered Customers</h2>
        @forelse ($customers as $customer)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-4 flex justify-between items-center">
                <div>
                    <p class="text-gray-700 dark:text-gray-200"><strong>Name:</strong> <span class="text-blue-600 dark:text-blue-400">{{ $customer->name }}</span></p>
                    <p class="text-gray-700 dark:text-gray-200"><strong>Email:</strong> <span class="text-green-600 dark:text-green-400">{{ $customer->email }}</span></p>
                    <p class="text-gray-700 dark:text-gray-200"><strong>Loan Officer:</strong>
                        @if ($customer->loanOfficer)
                            <span class="text-indigo-600 dark:text-indigo-400">{{ $customer->loanOfficer->name }}</span>
                        @else
                            <span class="text-red-600 dark:text-red-400">Not Assigned</span>
                        @endif
                    </p>
                </div>
                <div>
                    <form action="{{ route('loan_officer.manage_user', ['user' => $customer->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ $customer->loan_officer_id ? 'Unassign' : 'Manage User' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No customers registered yet.</p>
        @endforelse
    </div>

    @if(session('message'))
        <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">Loans and Repayment Progress</h2>
        @forelse ($paidLoans as $loan)
        @php
            $paid     = $loan->payments->sum('amount');
            $total    = $loan->amount;
            $progress = $total > 0 ? ($paid / $total) * 100 : 0;
        @endphp
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-4">
                <p class="text-gray-700 dark:text-gray-200"><strong>Customer:</strong> <span class="text-blue-600 dark:text-blue-400">{{ $loan->customer->name }}</span></p>
                <p class="text-gray-700 dark:text-gray-200"><strong>Amount Paid:</strong> <span class="text-green-600 dark:text-green-400">{{ number_format($loan->amount, 2) }} UGX</span></p>
                <p class="text-gray-700 dark:text-gray-200"><strong>Loan Type:</strong> <span class="text-gray-800 dark:text-gray-100">{{ $loan->loanType->name }}</span></p>
            </div>
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
                    UGX {{ number_format($paid) }} of UGX {{ number_format($total) }} paid
                    ({{ number_format($progress, 1) }}%)
                </p>
            </div>
        </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No paid loans yet.</p>
        @endforelse
    </div>

   


@endsection
