<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanType;
use App\Models\Loan;

class CustomerController extends Controller
{
    public function index()
    {
        //return view('customer.dashboard');
        $loans = Loan::where('customer_id', auth()->id())->with('loanType')->get();
        $loanTypes = LoanType::all();
        $paymentPlans = \App\Models\PaymentPlan::whereHas('loan', function ($query) {
            $query->where('customer_id', auth()->id());
        })->get();
        return view('customer.dashboard', compact('loans', 'loanTypes', 'paymentPlans'));
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

    \App\Models\Loan::create([
        'user_id' => auth()->id(),
        'amount' => $request->amount,
        'loan_type_id' => $request->loan_type_id,
        'status' => 'pending',
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

    return redirect()->route('customer.dashboard')->with('success', 'Loan application submitted.');
}

public function viewPaymentPlans()
{
    $paymentPlans = \App\Models\PaymentPlan::whereHas('loan', function ($query) {
        $query->where('customer_id', auth()->id());
    })->get();

    return view('customer.payment-plans', compact('paymentPlans'));
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
