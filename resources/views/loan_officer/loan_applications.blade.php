@extends('layouts.app')

@section('content')
<!-- Review Pending Loans -->
@if(auth()->user()->role == 'loan_officer')
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Loans to Review</h2>
            @forelse ($pendingLoans as $loan)
                <div class="bg-white shadow-md rounded-lg p-6 mb-4 flex justify-between items-center">
                    <div>
                        <p class="text-gray-700"><strong>Customer:</strong> <span class="text-blue-600">{{ $loan->customer->name }}</span></p>
                        <p class="text-gray-700"><strong>Amount:</strong> <span class="text-green-600">{{ number_format($loan->amount, 2) }} UGX</span></p>
                        <p class="text-gray-700"><strong>Loan Type:</strong> <span class="text-gray-800">{{ $loan->loanType->name }}</span></p>
                        <p class="text-gray-700"><strong>Status:</strong>
                            <span class="font-semibold
                                @if ($loan->status === 'approved') text-green-600
                                @elseif ($loan->status === 'pending') text-yellow-600
                                @elseif ($loan->status === 'rejected') text-red-600
                                @else text-gray-600 @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                         <a href="{{ route('loan_officer.loans.show', $loan->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No loans to review.</p>
            @endforelse
        </div>
    @endif
    @endsection