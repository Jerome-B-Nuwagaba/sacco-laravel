@extends('layouts.app')

@section('content')
    @if(auth()->user()->role == 'loan_officer')
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Loans to Review</h2>
            @php
                $loanApplications = \App\Models\Loan::where('loan_officer_id', auth()->user()->id)
                                                    ->where('status', 'pending')
                                                    ->get();
                //dd($loanApplications);
            @endphp
            @forelse ($loanApplications as $loan)
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
                        <button data-loan-id="{{ $loan->id }}" class="view-details-btn bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            View Details
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No loans to review.</p>
            @endforelse
        </div>

        <div id="loanDetailsOverlay" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 hidden justify-center items-center">
            <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4">Loan Details</h2>
                <div id="loanDetailsContent">
                    </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button id="rejectLoanBtn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Reject Loan
                    </button>
                    <button id="forwardLoanBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Forward Loan
                    </button>
                    <button id="closeOverlayBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
        const loanDetailsOverlay = document.getElementById('loanDetailsOverlay');
        const loanDetailsContent = document.getElementById('loanDetailsContent');
        const closeOverlayBtn = document.getElementById('closeOverlayBtn');
        const rejectLoanBtn = document.getElementById('rejectLoanBtn');
        const forwardLoanBtn = document.getElementById('forwardLoanBtn');
        let currentLoanId = null;

        // Show overlay and fetch loan details
        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', function () {
                currentLoanId = this.dataset.loanId;
                fetchLoanDetails(currentLoanId);
                loanDetailsOverlay.classList.remove('hidden');
                loanDetailsOverlay.classList.add('flex');
            });
        });

        // Close overlay
        closeOverlayBtn.addEventListener('click', function () {
            loanDetailsOverlay.classList.add('hidden');
            loanDetailsOverlay.classList.remove('flex');
            loanDetailsContent.innerHTML = ''; // Clear previous content
        });

        // Reject Loan
        rejectLoanBtn.addEventListener('click', function () {
            if (currentLoanId && confirm('Are you sure you want to reject this loan application?')) {
                window.location.href = `/loan_officer/loans/${currentLoanId}/reject`;
            }
        });

        // Forward Loan
        forwardLoanBtn.addEventListener('click', function () {
            if (currentLoanId) {
                window.location.href = `/loan_officer/loans/${currentLoanId}/forward`;
            }
        });

        // Fetch loan details partial view (HTML)
        function fetchLoanDetails(loanId) {
            fetch(`/loan_officer/loans/${loanId}/details`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    loanDetailsContent.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching loan details:', error);
                    loanDetailsContent.innerHTML = '<p class="text-red-500">Error loading loan details.</p>';
                });
        }
    });
</script>

    @endif
@endsection