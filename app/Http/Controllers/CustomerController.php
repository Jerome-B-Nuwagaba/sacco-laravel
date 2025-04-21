<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\PaymentPlanRejected;
use App\Models\LoanType;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\PaymentPlan;
use App\Models\SupportRequest;

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
                        //->where('accepted', false)
                        ->get();

    $recentPayments = \App\Models\Payment::whereHas('loan', function ($query) {
        $query->where('customer_id', auth()->id());
    })
    ->latest()
    ->take(5)
    ->get();

    $pastLoans = Loan::where('customer_id', $user->id)
                    ->where('status', '!=', 'accepted')
                    ->with('loanType')
                    ->get();

    return view('customer.dashboard', compact('currentLoan', 'paymentPlans', 'recentPayments', 'pastLoans'));
}

    public function myLoans()
    {
        $loans = Loan::where('customer_id', auth()->id())
                     ->with('loanType')
                     ->latest()
                     ->get();
        $loanTypes = LoanType::all();
    
        return view('customer.myloans', compact('loans','loanTypes'));
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
    // Notify the loan officer if assigned
    if ($customer->loan_officer_id) {
        $loanOfficer = User::find($customer->loan_officer_id);

        $loanOfficer->notify(new LoanApplicationNotification(
            "{$customer->name} submitted a new loan application.",
            route('loan_officer.loan_applications')
        ));
    }


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

    /*if ($plan->loan->loanOfficer) {
        $plan->loan->loanOfficer->notify(new \App\Notifications\PaymentPlanAccepted($plan));
    } */

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

    // Notify the loan officer who created the plan
    if ($plan->created_by) {
        $loanOfficer = \App\Models\User::find($plan->created_by);
        if ($loanOfficer) {
            $loanOfficer->notify(new PaymentPlanRejected($plan));
        }
    }

    // Optionally, delete the rejected plan
    //$plan->delete();

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
}
