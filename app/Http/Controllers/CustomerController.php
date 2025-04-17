<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanType;
use App\Models\Loan;

class CustomerController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $currentLoan = \App\Models\Loan::where('customer_id', $user->id)
                        ->where('status', 'accepted')
                        ->with(['loanType', 'payments'])
                        ->latest()
                        ->first();

    $paymentPlans = \App\Models\PaymentPlan::whereHas('loan', fn ($q) => $q->where('customer_id', $user->id))
                        ->where('accepted', false)
                        ->get();

    $recentPayments = \App\Models\Payment::whereHas('loan', fn ($q) => $q->where('customer_id', $user->id))
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

    return redirect()->back()->with('success', 'Payment plan accepted.');
}

public function showPayLoan()
{
    $loans = \App\Models\Loan::where('customer_id', auth()->id())->get();
    return view('customer.pay-loan', compact('loans'));
}

public function processLoanPayment(Request $request)
{
    $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'amount' => 'required|integer|min:1',
    ]);

    \App\Models\LoanPayment::create([
        'loan_id' => $request->loan_id,
        'amount' => $request->amount,
    ]);

    return redirect()->back()->with('success', 'Payment submitted.');
}
}
