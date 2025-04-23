@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Approved Loans</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($loans as $loan)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $loan->customer->name }}</p>
                <p class="text-gray-600 dark:text-gray-400">Loan Amount: {{ number_format($loan->amount, 2) }} UGX</p>
                <p class="text-gray-600 dark:text-gray-400">Approved: {{ $loan->updated_at->format('d M, Y') }}</p>

                @if($loan->paymentPlan)

                <button
                    class="block w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-3"
                    data-loan-id="{{ $loan->id }}"
                    data-plan-id="{{ $loan->paymentPlan->id }}"
                    data-duration="{{ $loan->paymentPlan->installment_duration }}"
                    data-installments="{{ $loan->paymentPlan->number_of_installments }}"
                    data-amount="{{ $loan->paymentPlan->amount_per_installment }}"
                    data-completion="{{ $loan->paymentPlan->completion_date->format('Y-m-d') }}"
                    data-status="{{ $loan->paymentPlan->status }}"
                    data-payments="{{ json_encode($loan->payments->map(function ($payment) {
                        return ['date' => $payment->payment_date, 'amount' => number_format($payment->amount, 2) . ' UGX'];
                    })) }}"
                    onclick="openViewOverlay(event)">
                    View Payment Plan
                </button>
                @else

                <button
                    class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mt-3"
                    data-loan-id="{{ $loan->id }}"
                    data-loan-amount="{{ $loan->amount }}"
                    onclick="openOverlay(event)">
                    Create Payment Plan
                </button>
                @endif
            </div>
        @endforeach
    </div>

    <div class="max-w-5xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Rejected Payment Plans</h2>

    @forelse ($rejectedPlans as $plan)
        <div class="bg-white dark:bg-gray-800 border border-red-300 dark:border-red-600 p-6 mb-6 rounded-lg shadow-sm">
            <p class="text-gray-800 dark:text-gray-200 mb-2">
                <strong>Customer:</strong> {{ $plan->loan->customer->name ?? 'N/A' }}
            </p>
            <p class="text-gray-700 dark:text-gray-300 mb-2">
                <strong>Loan ID:</strong> {{ $plan->loan_id }}
            </p>
            <p class="text-gray-700 dark:text-gray-300 mb-2">
                <strong>Installment Amount:</strong> UGX {{ number_format($plan->amount_per_installment) }}
            </p>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                <strong>Installments:</strong> {{ $plan->number_of_installments }}
            </p>

            {{-- Button to create a new plan --}}
            <form action="{{ route('loan_officer.plans.new') }}" method="GET">
                <input type="hidden" name="loan_id" value="{{ $plan->loan_id }}">
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow transition"
                >
                    Create New Plan
                </button>
            </form>
        </div>
    @empty
        <p class="text-gray-600 dark:text-gray-300">No rejected plans found.</p>
    @endforelse
</div>

<div class="max-w-2xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Create New Payment Plan</h2>

    <form action="{{ route('loan_officer.plans.store') }}" method="POST" class="space-y-4">
        @csrf

        <input type="hidden" name="loan_id" value="{{ $loanId }}">

        <div>
            <label class="block text-gray-700 dark:text-gray-300">Amount Per Installment</label>
            <input type="number" name="amount_per_installment" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300">Number of Installments</label>
            <input type="number" name="number_of_installments" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300">Completion Date</label>
            <input type="date" name="completion_date" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300">Installment Duration (e.g., weekly, monthly)</label>
            <input type="text" name="installment_duration" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
            Submit Plan
        </button>
    </form>
</div>

   @include('loan_officer.partials.payment-plan-overlay')
   @include('loan_officer.partials.view-payment-plan')


<script>
    function openViewOverlay(event) {
    const btn = event.currentTarget;
    const planId = btn.dataset.planId;
    const duration = btn.dataset.duration;
    const installments = btn.dataset.installments;
    const amount = parseFloat(btn.dataset.amount);
    const completion = btn.dataset.completion;
    const status = btn.dataset.status;
    const loanId = btn.dataset.loanId;
    const total = (amount * parseInt(installments, 10)).toFixed(2);
    const paymentsData = JSON.parse(btn.dataset.payments); // Get payments from data attribute

    // Populate fields
    document.getElementById('view_loan_id').innerText = planId;
    document.getElementById('view_installment_duration').innerText = duration.charAt(0).toUpperCase() + duration.slice(1);
    document.getElementById('view_number_of_installments').innerText = installments;
    document.getElementById('view_amount_per_installment').innerText = amount.toLocaleString() + ' UGX';
    document.getElementById('view_completion_date').innerText = new Date(completion).toLocaleDateString();
    document.getElementById('view_total_amount').innerText = parseFloat(total).toLocaleString() + ' UGX';
    document.getElementById('view_payment_plan_status').innerText = status.charAt(0).toUpperCase() + status.slice(1);

    // Get the payments list element
    const paymentsList = document.getElementById('view_payments_list');
    paymentsList.innerHTML = ''; // Clear any previous content

    if (paymentsData && paymentsData.length > 0) {
        paymentsData.forEach(payment => {
            const listItem = document.createElement('li');
            listItem.textContent = `Date: ${payment.date}, Amount: ${payment.amount}`;
            paymentsList.appendChild(listItem);
        });
    } else {
        const listItem = document.createElement('li');
        listItem.textContent = 'No payments made yet.';
        paymentsList.appendChild(listItem);
    }

    // Show overlay
    document.getElementById('view-payment-plan-overlay').classList.remove('hidden');
}

  function closeViewOverlay() {
    document.getElementById('view-payment-plan-overlay').classList.add('hidden');
  }
    function openOverlay(event) {
        const loanId = event.target.dataset.loanId;
        const loanAmount = parseFloat(event.target.dataset.loanAmount);

        document.getElementById('loan_id').value = loanId;
        document.getElementById('principal_amount').value = loanAmount.toFixed(2);
        document.getElementById('display_principal').value = loanAmount.toFixed(2);
        document.getElementById('total_amount').value = loanAmount.toFixed(2);

        document.getElementById('interest_rate').value = '';
        document.getElementById('installment_duration').value = '';
        document.getElementById('installment_count').value = '';
        document.getElementById('payment_per_installment').value = '';

        resetErrors();
        document.getElementById('payment-plan-overlay').classList.remove('hidden');
    }

    function closeOverlay() {
        document.getElementById('payment-plan-overlay').classList.add('hidden');
        resetErrors();
    }

    function resetErrors() {
        document.querySelectorAll('[id$="_error"]').forEach(el => el.classList.add('hidden'));
    }

    function calculatePayment() {
        resetErrors();

        const principal = parseFloat(document.getElementById('principal_amount').value) || 0;
        const interestRate = parseFloat(document.getElementById('interest_rate').value);
        const duration = document.getElementById('installment_duration').value;
        const installments = parseInt(document.getElementById('installment_count').value);

        let isValid = true;

        if (isNaN(interestRate) || interestRate < 0) {
            document.getElementById('interest_rate_error').classList.remove('hidden');
            isValid = false;
        }

        if (!duration) {
            document.getElementById('installment_duration_error').classList.remove('hidden');
            isValid = false;
        }

        if (isNaN(installments) || installments < 1) {
            document.getElementById('installment_count_error').classList.remove('hidden');
            isValid = false;
        }

        if (!isValid) return;

        const totalAmount = principal + (principal * interestRate / 100);
        const perInstallment = totalAmount / installments;

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        document.getElementById('payment_per_installment').value = perInstallment.toFixed(2);
    }


</script>
@endsection