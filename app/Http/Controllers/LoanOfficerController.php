<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanOfficerController extends Controller
{
    public function index()
    {
        return view('loan_officer.dashboard');
    }

    public function customers()
{
    $customers = \App\Models\User::where('role', 'customer')->get();
    return view('loan_officer.customers', compact('customers'));
}

public function reviewLoans()
{
    $loans = \App\Models\Loan::where('status', 'pending')->get();
    return view('loan_officer.review-loans', compact('loans'));
}

public function updateLoanStatus($loanId, Request $request)
{
    $request->validate([
        'action' => 'required|in:accepted,declined,forwarded',
    ]);

    $loan = \App\Models\Loan::findOrFail($loanId);
    $loan->status = $request->action;
    $loan->save();

    return redirect()->back()->with('success', 'Loan ' . $request->action);
}

public function paidLoans()
{
    $loans = \App\Models\Loan::where('status', 'paid')->get();
    return view('loan_officer.paid-loans', compact('loans'));
}

public function createPaymentPlan($loanId)
{
    $loan = \App\Models\Loan::findOrFail($loanId);
    return view('loan_officer.create-payment-plan', compact('loan'));
}

public function storePaymentPlan(Request $request)
{
    $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'amount_per_installment' => 'required|integer|min:1',
        'number_of_installments' => 'required|integer|min:1',
        'completion_date' => 'required|date|after:today',
    ]);

    \App\Models\PaymentPlan::create([
        'loan_id' => $request->loan_id,
        'amount_per_installment' => $request->amount_per_installment,
        'number_of_installments' => $request->number_of_installments,
        'completion_date' => $request->completion_date,
    ]);

    return redirect()->route('loan_officer.dashboard')->with('success', 'Payment plan created.');
}
}
