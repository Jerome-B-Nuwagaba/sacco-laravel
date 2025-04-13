<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $loanOfficers = \App\Models\User::where('role', 'loan_officer')->get();
        $customers = User::where('role', 'customer')->with('company')->get();
    $forwardedLoans = \App\Models\Loan::where('status', 'forwarded')->get();

    $analytics = [
        'daily' => \App\Models\Loan::whereDate('created_at', today())->count(),
        'weekly' => \App\Models\Loan::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        'monthly' => \App\Models\Loan::whereMonth('created_at', now()->month)->count(),
    ];
        return view('admin.dashboard', compact('loanOfficers', 'customers', 'forwardedLoans', 'analytics'));
    }

    public function viewUsers()
{
    $loanOfficers = \App\Models\User::where('role', 'loan_officer')->get();
    $customers = User::where('role', 'customer')->with('company')->get();
    return view('admin.users', compact('loanOfficers', 'customers'));
}

public function forwardedLoans()
{
    $loans = \App\Models\Loan::where('status', 'forwarded')->get();
    return view('admin.forwarded-loans', compact('loans'));
}

public function approveLoan($loanId)
{
    $loan = \App\Models\Loan::findOrFail($loanId);
    $loan->status = 'approved';
    $loan->save();

    return redirect()->back()->with('success', 'Loan approved.');
}

public function createLoanType()
{
    return view('admin.create-loan-type');
}

public function storeLoanType(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:loan_types,name',
    ]);

    \App\Models\LoanType::create(['name' => $request->name]);

    return redirect()->route('admin.dashboard')->with('success', 'Loan type added.');
}

public function analytics()
{
    $daily = \App\Models\Loan::whereDate('created_at', today())->count();
    $weekly = \App\Models\Loan::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    $monthly = \App\Models\Loan::whereMonth('created_at', now()->month)->count();

    return view('admin.analytics', compact('daily', 'weekly', 'monthly'));
}
}
