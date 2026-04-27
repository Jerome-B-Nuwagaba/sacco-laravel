<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanType;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\PaymentPlan;
use App\Models\SupportRequest;
use App\Services\MLPredictionService;

class CustomerController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $currentLoan = \App\Models\Loan::where('customer_id', $user->id)
                        ->whereIn('status', ['approved', 'active'])
                        ->with(['loanType', 'payments'])
                        ->latest()
                        ->first();

    $paymentPlans = \App\Models\PaymentPlan::whereHas('loan', fn ($q) => $q->where('customer_id', $user->id))
                        ->whereNull('deleted_at')
                        ->get();

    $recentPayments = \App\Models\Payment::whereHas('loan', function ($query) {
        $query->where('customer_id', auth()->id());
    })
    ->latest()
    ->take(5)
    ->get();

    $pastLoans = Loan::where('customer_id', $user->id)
                    ->where('status', '!=', 'active')
                    ->with('loanType')
                    ->get();

    return view('customer.dashboard', compact('currentLoan', 'paymentPlans', 'recentPayments', 'pastLoans'));
}

public function myLoans()
{
    $user = auth()->user();
    $loans = Loan::where('customer_id', auth()->id())
                 ->with('loanType', 'paymentPlan') 
                 ->latest()
                 ->get();
    $loanTypes = LoanType::all();
    $paymentPlans = \App\Models\PaymentPlan::whereHas('loan', fn ($q) => $q->where('customer_id', $user->id))
                                         ->whereNull('deleted_at')
                                         ->latest()
                                         ->get();
    return view('customer.myloans', compact('loans', 'loanTypes', 'paymentPlans'));
}
    
    public function createLoan()
{
    $loanTypes = LoanType::all(); // Admin-defined types
    return view('customer.dashboard', compact('loanTypes'));
}

public function applyLoan(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'loan_type_id' => 'required|exists:loan_types,id',
    ]);
    // 5. Handle file uploads for business loans
    $documentPaths = [];
    if ($request->hasFile('business_documents')) {
        $request->validate([
            'business_documents' => 'required|array',
            'business_documents.*' => 'file|mimes:pdf,doc,docx,jpeg,png|max:2048',
        ]);
        foreach ($request->file('business_documents') as $file) {
            $path = $file->store('business_documents', 'public');
            $documentPaths[] = $path;
        }
    }

    \App\Models\Loan::create([
        'customer_id' => auth()->id(),
        'amount' => $request->amount,
        'loan_type_id' => $request->loan_type_id,
        'status' => 'pending',
        'loan_officer_id' => auth()->user()->loan_officer_id,
        'business_documents' => $documentPaths ? json_encode($documentPaths) : null,    
    ]);

    return redirect()->route('customer.dashboard')->with('success', 'Loan application submitted!');
}

public function storeLoan(Request $request)
{
    $request->validate([
        'amount' => 'required|integer|min:1',
        'loan_type_id' => 'required|exists:loan_types,id',
    ]);

    \App\Models\Loan::create([
        'customer_id' => auth()->id(),
        'amount' => $request->amount,
        'loan_type_id' => $request->loan_type_id,
        'status' => 'pending',
        'loan_officer_id' => auth()->user()->loan_officer_id,
    ]);
    



    return redirect()->route('customer.dashboard')->with('success', 'Loan application submitted.');
}

public function viewPaymentPlans()
{
    $paymentPlans = \App\Models\PaymentPlan::whereHas('loan', function ($query) {
        $query->where('customer_id', auth()->id());
    })->get();

    return view('customer.payments', compact('paymentPlans'));
}

public function acceptPaymentPlan($id)
{
    $plan = \App\Models\PaymentPlan::findOrFail($id);

    // Optional: validate ownership
    if ($plan->loan->customer_id !== auth()->id()) {
        abort(403);
    }

    $plan->accepted = true;
    $plan->save();

    
    return redirect()->back()->with('success', 'Payment plan accepted.');
}

public function showPayLoan()
{
    $loans = \App\Models\Loan::where('customer_id', auth()->id())->get();
    $loan = Loan::with('paymentPlan')
        ->where('id', $loanId)
        ->where('customer_id', auth()->id())
        ->firstOrFail();

    if (!$loan->paymentPlan || !$loan->paymentPlan->accepted) {
        return redirect()->back()->with('error', 'You cannot pay until the payment plan is accepted.');
    }

    
    return view('customer.pay-loan', compact('loans'));
}

public function processLoanPayment(Request $request, $loanId)
{
    $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'amount' => 'required|integer|min:1',
    ]);
    
    $loan = Loan::with('paymentPlan')
        ->where('id', $loanId)
        ->where('customer_id', auth()->id())
        ->firstOrFail();

    if (!$loan->paymentPlan || !$loan->paymentPlan->accepted) {
        return redirect()->back()->with('error', 'Payment plan must be accepted before making a payment.');
    }

    \App\Models\Payment::create([
        'loan_id' => $loanId,
        'amount' => $request->amount,        
        'payment_date' => now(),
    ]);
    $loan->load('payments');
    $totalPaid = $loan->payments->sum('amount') + $request->amount;
    $totalExpected = $loan->paymentPlan->amount_per_installment * $loan->paymentPlan->number_of_installments;

    if ($totalPaid >= $totalExpected) {
        $loan->paymentPlan->update(['status' => 'completed']);
       
    }
    return redirect()->back()->with('success', 'UGX '.number_format($request['amount']).' paid sucessfuly!!!');
}

public function rejectPaymentPlan($planId)
{
    $plan = PaymentPlan::whereHas('loan', function ($query) {
        $query->where('customer_id', auth()->id());
    })->findOrFail($planId);

    $plan->accepted = '0';
    $plan->save();


    // Optionally, delete the rejected plan
    $plan->delete();

    return redirect()->back()->with('success', 'Payment plan rejected. The loan officer will create a new one.');
}
public function supportPage()
{
  
    $faqs = [
        ['question' => 'How can I apply for a loan?', 'answer' => 'To apply for a loan, go to the Loans section and fill out the application form.'],
        ['question' => 'What is the repayment schedule?', 'answer' => 'The repayment schedule is defined by your assigned loan officer after aproval.'],
       
    ];
    // Fetch the updated list of support requests with replies for the current user
    $replies = SupportRequest::where('user_id', auth()->id())
    ->with('replier')
    ->latest()
    ->get();
    return view('customer.support', compact('faqs', 'replies'));
}

public function submitSupportRequest(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:1000',
        'email' => 'required|email',
    ]);

    // Store the support request
    SupportRequest::create([
        'user_id' => auth()->id(),
        'email' => $request->email,
        'message' => $request->message,
    ]);
    return redirect()->route('customer.support')->with('success', 'Your support request has been submitted!');
}

public function __construct(private MLPredictionService $mlService) {}

    public function assess(Request $request)
    {
        $validated = $request->validate([
            'member_id'           => 'required|exists:members,id',
            'age'                 => 'required|integer|min:18|max:80',
            'membership_years'    => 'required|integer|min:0',
            'annual_income_ugx'   => 'required|integer|min:0',
            'annual_savings_ugx'  => 'required|integer|min:0',
            'loan_amount_ugx'     => 'required|integer|min:100000',
            'land_size_acres'     => 'required|numeric|min:0',
            'collateral_ugx'      => 'required|integer|min:0',
            'num_guarantors'      => 'required|integer|min:0',
            'emp_length_years'    => 'required|numeric|min:0',
            'primary_crop'        => 'required|string',
            'loan_grade'          => 'required|in:A,B,C,D,E,F,G',
            'loan_purpose'        => 'required|string',
            'interest_rate_pct'   => 'required|numeric|min:0',
            'loan_pct_income'     => 'required|numeric|min:0',
            'credit_hist_years'   => 'required|integer|min:0',
            'prior_default_num'   => 'required|in:0,1',
            'profitability_2022'  => 'required|integer|min:1|max:5',
            'profitability_2023'  => 'required|integer|min:1|max:5',
            'soil_acidity'        => 'required|integer|min:1|max:5',
            'rainfall_2022_mm'    => 'required|numeric|min:0',
            'rainfall_2023_mm'    => 'required|numeric|min:0',
            'temperature_c'       => 'required|numeric',
            'humidity'            => 'required|numeric|min:0|max:100',
            'wind_speed'          => 'required|numeric|min:0',
            'district'            => 'required|string',
            'region'              => 'required|string',
            'total_rainfall_mm'   => 'required|numeric|min:0',
            'avg_temp_c'          => 'required|numeric',
            'drought_flag'        => 'required|in:0,1',
            'flood_risk_flag'     => 'required|in:0,1',
            'weather_risk_score'  => 'required|numeric|min:0|max:10',
        ]);

        // Call the ML service
        $prediction = $this->mlService->predict($validated);

        if (!$prediction) {
            // ML service is down — save application anyway, flag for manual review
            return response()->json([
                'message' => 'ML service unavailable. Application saved for manual review.',
                'ml_available' => false,
            ], 202);
        }

        // Save the prediction alongside the loan application
        $loan = Loan::create([
            'member_id'              => $validated['member_id'],
            'requested_amount_ugx'   => $validated['loan_amount_ugx'],
            'recommended_amount_ugx' => $prediction['recommended_loan_ugx'],
            'credit_score'           => $prediction['credit_score'],
            'risk_level'             => $prediction['risk_level'],
            'risk_probabilities'     => json_encode($prediction['risk_probabilities']),
            'policy_flags'           => json_encode($prediction['policy_flags']),
            'uncertainty_warning'    => $prediction['uncertainty_warning'],
            'ml_assessed_at'         => now(),
            'status'                 => 'pending_review',
        ]);

        return response()->json([
            'loan_id'    => $loan->id,
            'prediction' => $prediction,
        ]);
    }

}
