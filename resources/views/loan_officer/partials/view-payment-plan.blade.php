{{-- view-payment-plan-overlay.blade.php --}}
<div
    id="view-payment-plan-overlay"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
>
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md relative">
    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
      Payment Plan Details
    </h3>

    <div class="space-y-3 text-gray-700 dark:text-gray-300">
      <p><strong>Loan ID:</strong> <span id="view_loan_id"></span></p>
      <p><strong>Payment Frequency:</strong> <span id="view_installment_duration"></span></p>
      <p><strong>Number of Installments:</strong> <span id="view_number_of_installments"></span></p>
      <p><strong>Per Installment:</strong> <span id="view_amount_per_installment"></span></p>
      <p><strong>Completion Date:</strong> <span id="view_completion_date"></span></p>
      <p><strong>Total Amount:</strong> <span id="view_total_amount"></span></p>
    </div>

    <button
      onclick="closeViewOverlay()"
      class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 text-xl font-bold"
    >
      ×
    </button>
  </div>
</div>
