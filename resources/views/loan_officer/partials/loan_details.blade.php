<div>
    <p class="text-gray-700 dark:text-gray-300"><strong>Customer Name:</strong> <span class="text-blue-600 dark:text-blue-400">{{ $loan->customer->name }}</span></p>
    <p class="text-gray-700 dark:text-gray-300"><strong>Customer Email:</strong> {{ $loan->customer->email }}</p>
    <p class="text-gray-700 dark:text-gray-300"><strong>Customer Phone:</strong> {{ $loan->customer->phone_number }}</p>
    <hr class="my-2 border-gray-300 dark:border-gray-600">
    <p class="text-gray-700 dark:text-gray-300"><strong>Loan Amount:</strong> <span class="text-green-600 dark:text-green-400">{{ number_format($loan->amount, 2) }} UGX</span></p>
    <p class="text-gray-700 dark:text-gray-300"><strong>Loan Type:</strong> {{ $loan->loanType->name }}</p>
    <p class="text-gray-700 dark:text-gray-300"><strong>Applied On:</strong> {{ $loan->created_at->format('d M Y') }}</p>
</div>
