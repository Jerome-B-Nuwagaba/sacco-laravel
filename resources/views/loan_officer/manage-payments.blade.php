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
        data-plan-id="{{ $loan->paymentPlan->id }}"
        data-duration="{{ $loan->paymentPlan->installment_duration }}"
        data-installments="{{ $loan->paymentPlan->number_of_installments }}"
        data-amount="{{ $loan->paymentPlan->amount_per_installment }}"
        data-completion="{{ $loan->paymentPlan->completion_date->format('Y-m-d') }}"
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
        
    </div>

   <!-- Include  Overlay Partial -->
   @include('loan_officer.partials.payment-plan-overlay')
   @include('loan_officer.partials.view-payment-plan')


<script>
     function openViewOverlay(event) {
    const btn     = event.currentTarget;
    const planId  = btn.dataset.planId;
    const duration = btn.dataset.duration;
    const installments = btn.dataset.installments;
    const amount = parseFloat(btn.dataset.amount);
    const completion = btn.dataset.completion;
    const total = (amount * parseInt(installments, 10)).toFixed(2);

    // Populate fields
    document.getElementById('view_loan_id').innerText = planId;
    document.getElementById('view_installment_duration').innerText = duration.charAt(0).toUpperCase() + duration.slice(1);
    document.getElementById('view_number_of_installments').innerText = installments;
    document.getElementById('view_amount_per_installment').innerText = amount.toLocaleString() + ' UGX';
    document.getElementById('view_completion_date').innerText = new Date(completion).toLocaleDateString();
    document.getElementById('view_total_amount').innerText = parseFloat(total).toLocaleString() + ' UGX';

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