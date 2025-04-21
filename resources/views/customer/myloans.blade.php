@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-gray-50 dark:bg-gray-900">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">My Loans</h2>
            @forelse ($loans as $loan)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Type:</strong>
                        <span class="text-blue-600 dark:text-blue-400">{{ $loan->loanType->name }}</span>
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Amount:</strong>
                        <span class="text-green-600 dark:text-green-400">{{ number_format($loan->amount, 2) }} UGX</span>
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Status:</strong>
                        <span class="font-semibold
                            @if ($loan->status === 'approved') text-green-600 dark:text-green-400
                            @elseif ($loan->status === 'pending') text-yellow-600 dark:text-yellow-400
                            @elseif ($loan->status === 'rejected') text-red-600 dark:text-red-400
                            @else text-gray-600 dark:text-gray-400 @endif">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </p>

                    @if ($loan->status === 'approved')
                        <a href="{{route('customer.payments')}}" class="inline-block bg-green-500 hover:bg-green-600 focus:ring-2 focus:ring-offset-2 focus:ring-green-400  text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-150" >
                            Make Payment
                        </a>
@endif

                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No loan applications yet.</p>
            @endforelse
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Apply for a Loan</h2>
            @if ($loans->count() < 2)
                <form action="{{ route('customer.applyLoan') }}" method="POST" enctype="multipart/form-data"
                      class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                    @csrf

                    <div class="mb-4">
                        <label for="loan_type_id" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            Loan Type
                        </label>
                        <select
                            name="loan_type_id"
                            id="loan_type_id"
                            class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3
                                   bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 leading-tight
                                   focus:outline-none focus:shadow-outline focus:bg-white dark:focus:bg-gray-600"
                            required
                            onchange="handleLoanTypeChange(this)"
                        >
                            <option value="">Select Loan Type</option>
                            @foreach ($loanTypes as $loanType)
                                <option
                                  value="{{ $loanType->id }}"
                                  data-lower-limit="{{ $loanType->lower_limit }}"
                                  data-upper-limit="{{ $loanType->upper_limit }}"
                                >
                                    {{ $loanType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('loan_type_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            Loan Amount (UGX)
                        </label>
                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            step="100"
                            class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3
                                   bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 leading-tight
                                   focus:outline-none focus:shadow-outline focus:bg-white dark:focus:bg-gray-600"
                            required
                        >
                        <p id="amount-limits" class="text-gray-500 dark:text-gray-400 text-xs italic mt-1"></p>
                        @error('amount')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="business-documents" class="hidden mb-4">
                        <label for="business_documents" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            Business Documents
                        </label>
                        <input
                            type="file"
                            name="business_documents[]"
                            id="business_documents"
                            multiple
                            class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3
                                   bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 leading-tight
                                   focus:outline-none focus:shadow-outline focus:bg-white dark:focus:bg-gray-600"
                        >
                        <p class="text-gray-500 dark:text-gray-400 text-xs italic mt-1">
                            Upload relevant business documents (e.g., registration, financial statements).
                        </p>
                        @error('business_documents')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                        @error('business_documents.*')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="bg-green-500 hover:bg-green-700 dark:hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    >
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
