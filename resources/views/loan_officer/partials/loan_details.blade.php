<div>
    <p class="text-gray-700"><strong>Customer Name:</strong> <span class="text-blue-600">{{ $loan->customer->name }}</span></p>
    <p class="text-gray-700"><strong>Customer Email:</strong> {{ $loan->customer->email }}</p>
    <p class="text-gray-700"><strong>Customer Phone:</strong> {{ $loan->customer->phone_number }}</p>
    <hr class="my-2">
    <p class="text-gray-700"><strong>Loan Amount:</strong> <span class="text-green-600">{{ number_format($loan->amount, 2) }} UGX</span></p>
    <p class="text-gray-700"><strong>Loan Type:</strong> {{ $loan->loanType->name }}</p>
    <p class="text-gray-700"><strong>Interest Rate:</strong> {{ $loan->loanType->interest_rate ?? 'N/A' }}%</p>
    <p class="text-gray-700"><strong>Loan Term:</strong> {{ $loan->loanType->term_months ?? 'N/A' }} months</p>
    <p class="text-gray-700"><strong>Applied On:</strong> {{ $loan->created_at->format('d M Y') }}</p>
</div>
