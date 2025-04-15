@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">My Loans</h2>
            @forelse ($loans as $loan)
                <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                    <p class="text-gray-700"><strong>Type:</strong> <span class="text-blue-600">{{ $loan->loanType->name }}</span></p>
                    <p class="text-gray-700"><strong>Amount:</strong> <span class="text-green-600">{{ number_format($loan->amount, 2) }} UGX</span></p>
                    <p class="text-gray-700"><strong>Status:</strong>
                        <span class="font-semibold
                            @if ($loan->status === 'approved') text-green-600
                            @elseif ($loan->status === 'pending') text-yellow-600
                            @elseif ($loan->status === 'rejected') text-red-600
                            @else text-gray-600 @endif">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </p>

                    @if ($loan->status === 'approved')
                        <form action="{{ route('customer.loans.pay', $loan->id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="mb-3">
                                <label for="payment_amount" class="block text-gray-700 text-sm font-bold mb-2">Payment Amount (UGX)</label>
                                <input type="number" name="payment_amount" id="payment_amount" placeholder="Enter payment amount"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Pay
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">No loan applications yet.</p>
            @endforelse
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Apply for a Loan</h2>
            @if ($loans->count() < 2)
                <form action="{{ route('customer.applyLoan') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
                    @csrf

                    <div class="mb-4">
                        <label for="loan_type_id" class="block text-gray-700 text-sm font-bold mb-2">Loan Type</label>
                        <select name="loan_type_id" id="loan_type_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required onchange="handleLoanTypeChange(this)">
                            <option value="">Select Loan Type</option>
                            @foreach ($loanTypes as $loanType)
                                <option value="{{ $loanType->id }}" data-lower-limit="{{ $loanType->lower_limit }}"
                                        data-upper-limit="{{ $loanType->upper_limit }}">
                                    {{ $loanType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('loan_type_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Loan Amount (UGX)</label>
                        <input type="number" name="amount" id="amount" step="100"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        <p id="amount-limits" class="text-gray-500 text-xs italic mt-1"></p>
                        @error('amount')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="business-documents" class="hidden mb-4">
                        <label for="business_documents" class="block text-gray-700 text-sm font-bold mb-2">Business Documents</label>
                        <input type="file" name="business_documents[]" id="business_documents" multiple
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               >
                        <p class="text-gray-500 text-xs italic mt-1">Upload relevant business documents (e.g., registration, financial statements).</p>
                        @error('business_documents')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                        @error('business_documents.*')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Apply
                    </button>
                </form>
            @else
                 <p class="text-red-500 font-semibold">You have reached the maximum limit of two active loans.</p>
            @endif
        </div>
    </div>

    <script>
        const businessDocumentsDiv = document.getElementById('business-documents');
        const loanTypeSelect = document.getElementById('loan_type_id');
        const amountInput = document.getElementById('amount');
        const amountLimitsParagraph = document.getElementById('amount-limits');

        function handleLoanTypeChange(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const lowerLimit = parseInt(selectedOption.getAttribute('data-lower-limit'));
            const upperLimit = parseInt(selectedOption.getAttribute('data-upper-limit'));
            const selectedLoanTypeName = selectedOption.textContent.trim().toLowerCase();

            if (selectedLoanTypeName === 'business loan') {
                businessDocumentsDiv.classList.remove('hidden');
            } else {
                businessDocumentsDiv.classList.add('hidden');
            }

            amountLimitsParagraph.textContent = `Amount should be between ${formatNumber(lowerLimit)} UGX and ${formatNumber(upperLimit)} UGX.`;
            amountInput.min = lowerLimit;
            amountInput.max = upperLimit;
            amountInput.value = ''; // Reset the amount input when loan type changes
        }

        function formatNumber(number) {
            return new Intl.NumberFormat('en-UG', { 
                style: 'decimal',
                currency: 'UGX',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(number);
        }

        // Initial setup to handle default selected value if any
        if (loanTypeSelect.value) {
            handleLoanTypeChange(loanTypeSelect);
        }
    </script>
@endsection
