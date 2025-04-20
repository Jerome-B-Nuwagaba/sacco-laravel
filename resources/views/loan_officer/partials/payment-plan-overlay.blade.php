<div id="payment-plan-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Create Payment Plan</h3>

        <form id="payment-plan-form" method="POST" action="{{ route('loan_officer.payment_plan.store') }}">
            @csrf
            <input type="hidden" id="loan_id" name="loan_id">
            <input type="hidden" id="principal_amount">

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Principal Amount (UGX)</label>
                <input type="number" id="display_principal" class="w-full p-2 border rounded bg-gray-100 dark:bg-gray-700" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Interest Rate (%)</label>
                <input type="number" step="0.01" id="interest_rate" name="interest_rate"
                       class="w-full p-2 border rounded dark:bg-gray-700"
                       oninput="calculatePayment()">
                <div id="interest_rate_error" class="hidden text-red-500 text-sm mt-1">Please enter a valid interest rate</div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Payment Frequency</label>
                <select id="installment_duration" name="installment_duration"
                        class="w-full p-2 border rounded dark:bg-gray-700"
                        onchange="calculatePayment()">
                    <option value="">Select Frequency</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
                <div id="installment_duration_error" class="hidden text-red-500 text-sm mt-1">Please select a payment frequency</div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Number of Payments</label>
                <input type="number" id="installment_count" name="number_of_installments" class="w-full p-2 border rounded dark:bg-gray-700"
                       oninput="calculatePayment()">
                <div id="installment_count_error" class="hidden text-red-500 text-sm mt-1">Please enter a valid number of payments</div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Total Amount (UGX)</label>
                <input type="number" id="total_amount" name="total_amount"
                       class="w-full p-2 border rounded bg-gray-100 dark:bg-gray-700" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Payment per Installment (UGX)</label>
                <input type="number" id="payment_per_installment" name="amount_per_installment" class="w-full p-2 border rounded bg-gray-100 dark:bg-gray-700" readonly>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeOverlay()"
                        class="px-4 py-2 border rounded text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded transition-colors">
                    Create Plan
                </button>
            </div>
        </form>
    </div>
</div>