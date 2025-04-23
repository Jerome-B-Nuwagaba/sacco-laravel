<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use App\Models\PaymentPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LoanOfficerController extends Controller
{
    /*public function index()
    {
        $customers = \App\Models\User::where('role', 'customer')->get();
    $pendingLoans = \App\Models\Loan::where('status', 'pending')->get();
    $paidLoans = \App\Models\Loan::where('status', 'paid')->get();

    $pendingLoans = Loan::where('loan_officer_id', auth()->id())
        ->where('status', 'approved')
        ->doesntHave('paymentPlan')
        ->with('customer')
        ->get();

        $paidLoans = Loan::where('status', 'paid')->get();

        return view('loan_officer.dashboard', compact('customers', 'pendingLoans', 'paidLoans'));
    } */

    

    public function customers()
{
    $customers = \App\Models\User::where('role', 'customer')->get();
    return view('loan_officer.customers', compact('customers'));
}

public function dashboard()
{
    $loanOfficerId = auth()->id();

    $customers = User::where(function ($query) use ($loanOfficerId) {
        $query->whereNull('loan_officer_id') // New customers (unassigned)
              ->orWhere('loan_officer_id', $loanOfficerId); // Assigned to this loan officer
    })
    ->where('role', 'customer')
    ->get();

    $pendingLoans = Loan::where('loan_officer_id', $loanOfficerId)
        ->where('status', 'approved')
        ->doesntHave('paymentPlan')
        ->with('customer')
        ->get();

    $paidLoans = Loan::where('loan_officer_id', $loanOfficerId)
        ->whereIn('status', ['paid', 'in_progress'])
        ->with(['customer', 'loanType', 'payments'])
        ->get();

    return view('loan_officer.dashboard', compact('customers','pendingLoans', 'paidLoans'));
        $rejectedPlans = PaymentPlan::onlyTrashed()
    ->where('created_by', auth()->id())
    ->where('status', 'rejected')
    ->with('loan.customer') // if needed
    ->get();

    return view('loan_officer.dashboard', compact('customers','pendingLoans', 'paidLoans', 'notifications', 'rejectedPlans'));
}

public function reviewLoans()
{
    $loans = \App\Models\Loan::where('status', 'pending')
    ->where('loan_officer_id', auth()->id())
    ->get();
    return view('loan_officer.loan_applications', compact('loans'));
}
public function manageUser(Request $request, User $user)
{
    // 1. Update the user's loan_officer_id
    if ($user->loan_officer_id === auth()->id()) {
        $user->loan_officer_id = null; // Unassign
        $message = 'Loan Officer unassigned from user and their loans.';
    } else {
        $user->loan_officer_id = auth()->id(); // Assign
        $message = 'Loan Officer assigned to user and their loans.';
    }
    $user->save(); // Save the changes to the users table.

    // 2. Update the loans table
    if ($user->loan_officer_id !== null) {
        // Assign the loan officer to all loans belonging to this user.
        Loan::where('customer_id', $user->id)
            ->update(['loan_officer_id' => auth()->id()]);
    } else {
        // Unassign the loan officer from all loans belonging to this user.
        Loan::where('customer_id', $user->id)
            ->update(['loan_officer_id' => null]);
    }

    return redirect()->back()->with('message', $message);
}



public function show(Loan $loan)
{
    $loan = Loan::with('customer', 'loanType')->findOrFail($loan->id);

    return view('loan_officer.loan_applications', compact('loan')); 
}
public function showDetails(Loan $loan)
{
    $loan->load('customer', 'loanType');
    return view('loan_officer.partials.loan_details', compact('loan'));
}

public function updateLoanStatus($loanId, Request $request)
{
    $request->validate([
        'action' => 'required|in:declined,forwarded',
    ]);

    $loan = \App\Models\Loan::findOrFail($loanId);
    $loan->status = $request->action;
    $loan->save();
   
    // Notify customer
    $customer = $loan->customer; // assuming you have a relationship set up

    if ($customer) {
        $message = $request->action === 'forwarded'
            ? 'Your loan application has been forwarded for approval.'
            : 'Your loan application has been declined.';

        $customer->notify(new LoanApplicationNotification(
            $message,
            route('loan_officer.loans.show', $loan->id)
        ));
    }

    return redirect()->back()->with('success', 'Loan ' . $request->action);
}

public function paidLoans()
{
    //$loans = \App\Models\Loan::where('status', 'paid')
    $loans = \App\Models\Loan::where('loan_officer_id', auth()->id())
        ->whereIn('status', ['accepted', 'active', 'completed']) // loans in progress or done
        ->with(['customer', 'loanType', 'payments']) // eager load relationships
        ->latest()
        ->get();
   
    return view('loan_officer.paid-loans', compact('loans'));
}

public function createPaymentPlan()
{
    // Get the current loan officer's ID
    $loanOfficerId = Auth::id();

    $loans = Loan::where('loan_officer_id', $loanOfficerId)
            ->where('status', 'approved') 
            ->get();

            $rejectedPlans = PaymentPlan::onlyTrashed()
        ->where('created_by', auth()->id())
        ->where('status', 'rejected')
        ->with('loan.customer')
        ->get();

        $loanId = null;


    return view('loan_officer.manage-payments', compact('loans', 'rejectedPlans', 'loanId'));
}

public function forwardLoan($id)
{
    $loan = Loan::findOrFail($id);
    $loan->status = 'forwarded';
    $loan->save();

    return redirect()->back()->with('success', 'Loan forwarded successfully.');
}

public function rejectLoan($id)
{
    $loan = Loan::findOrFail($id);
    $loan->status = 'rejected';
    $loan->save();

    return redirect()->back()->with('success', 'Loan rejected.');
}

public function loanDetails($id)
{
    $loan = Loan::with(['customer', 'loanType'])->findOrFail($id);
    return view('loan-officer.partials.loan-details', compact('loan'));
}

public function managePayments()
{
    $loanOfficerId = auth()->id();

    $loans = Loan::where('loan_officer_id', $loanOfficerId)
        ->where('status', 'approved')
        ->with(['customer', 'paymentPlan', 'payments' => function ($query) {
            $query->orderBy('payment_date');
        }])
        ->get();

        $rejectedPlans = PaymentPlan::onlyTrashed()
        ->where('created_by', auth()->id())
        ->where('status', 'rejected')
        ->with('loan.customer')
        ->get();

    return view('loan_officer.manage-payments', compact('loans', 'rejectedPlans'));
}

public function storePaymentPlan(Request $request)
{
    $installments = (int) $request->input('number_of_installments');
    $completion_date = Carbon::now();

    if ($request->input('installment_duration') === 'weekly') {
        $completion_date = $completion_date->addWeeks($installments);
    } elseif ($request->input('installment_duration') === 'monthly') {
        $completion_date = $completion_date->addMonths($installments);
    }


    \App\Models\PaymentPlan::create([
        'loan_id'                 => $request->input('loan_id'),
        'amount_per_installment'  => $request->input('amount_per_installment'),
        'number_of_installments'  => $installments,
        'completion_date'         => $completion_date,
        'installment_duration'    => $request->input('installment_duration'),
        'created_by'              => auth()->id(),
    ]);

    return redirect()->route('loan_officer.dashboard')->with('success', 'Payment plan created.');
}

public function showPaymentPlan($loanId, Request $request)
{
    $loan = Loan::with(['customer', 'paymentPlan', 'payments'])->findOrFail($loanId);

    if ($request->wantsJson()) {
        // If it's an AJAX request (likely indicated by 'Accept: application/json' header)
        return response()->json([
            'status' => $loan->paymentPlan ? $loan->paymentPlan->status : 'Not Available',
            'payments' => $loan->payments->map(function ($payment) {
                return [
                    'date' => $payment->payment_date->format('d M, Y'),
                    'amount' => number_format($payment->amount, 2) . ' UGX',
                ];
            }),
        ]);
    } else {
        // If it's a regular page request, return the full view
        $rejectedPlans = PaymentPlan::onlyTrashed()
            ->where('created_by', auth()->id())
            ->where('status', 'rejected')
            ->with('loan.customer')
            ->get();
        
        return view('loan_officer.manage-payments', compact('loan', 'rejectedPlans'));
    }
}

public function rejectedPlans()
{
    $plans = PaymentPlan::onlyTrashed()
        ->where('created_by', auth()->id())
        ->where('status', 'rejected')
        ->with('loan.customer')
        ->get();

    return view('loan_officer.rejected-plans', compact('plans'));
}

public function createNewPlan(Request $request)
{
    $loanId = $request->input('loan_id');
    $loanOfficerId = auth()->id();

    $loans = \App\Models\Loan::where('loan_officer_id', $loanOfficerId)
        ->where('status', 'approved')
        ->with(['customer', 'paymentPlan', 'payments'])
        ->get();

    $rejectedPlans = \App\Models\PaymentPlan::onlyTrashed()
        ->where('created_by', $loanOfficerId)
        ->where('status', 'rejected')
        ->with('loan.customer')
        ->get();


    return view('loan_officer.manage-payments', compact('loans', 'rejectedPlans', 'loanId'));
}

public function showRejectedPlans()
{
    $rejectedPlans = PaymentPlan::onlyTrashed()
        ->where('status', 'rejected')
        ->with('loan') // if you want to show loan info
        ->get();

    return view('loan_officer.manage-payments', compact('rejectedPlans'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'amount_per_installment' => 'required|integer|min:1',
        'number_of_installments' => 'required|integer|min:1',
        'completion_date' => 'required|date',
        'installment_duration' => 'required|string',
    ]);

    PaymentPlan::create([
        'loan_id' => $validated['loan_id'],
        'amount_per_installment' => $validated['amount_per_installment'],
        'number_of_installments' => $validated['number_of_installments'],
        'completion_date' => $validated['completion_date'],
        'installment_duration' => $validated['installment_duration'],
        'status' => 'pending',
        'created_by' => auth()->id(),
    ]);

    return redirect()->route('loan_officer.rejected')->with('success', 'New payment plan created.');
}

}
