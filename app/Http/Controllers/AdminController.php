<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    public function index()
    {
        $loanOfficers = \App\Models\User::where('role', 'loan_officer')->get();
        $customers = User::where('role', 'customer')->get();
    $forwardedLoans = \App\Models\Loan::where('status', 'forwarded')->get();

    $analytics = [
        'daily' => \App\Models\Loan::whereDate('updated_at', today())->count(),
        'weekly' => \App\Models\Loan::whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        'monthly' => \App\Models\Loan::whereMonth('updated_at', now()->month)->count(),
        'users' => \App\Models\User::count(),
        'pending' => \App\Models\Loan::where('status', 'pending')->count(),
        'approved' => \App\Models\Loan::where('status', 'approved')->count(),
        'rejected' => \App\Models\Loan::where('status', 'rejected')->count(),
    ];
        return view('admin.dashboard', compact('loanOfficers', 'customers', 'forwardedLoans', 'analytics'));
    }

    public function viewEmployees()
{
    $loanOfficers = \App\Models\User::where('role', 'loan_officer')->get();
    return view('admin.users.employees', compact('loanOfficers'));
}
public function viewCustomers()
{
    $loanOfficers = \App\Models\User::where('role', 'loan_officer')->get();
    $customers = User::where('role', 'customer')->get();
    return view('admin.users.customers', compact( 'customers'));
}

public function forwardedLoans()
{
   $loans = \App\Models\Loan::where('status', 'forwarded')->with(['customer', 'loanType'])->get();
    return view('admin.loans', compact('loans'));
}

public function approveLoan($loanId)
{
    $loan = \App\Models\Loan::findOrFail($loanId);
    $loan->status = 'approved';
    $loan->save();

    return redirect()->back()->with('success', 'Loan approved.');
}
public function rejectLoan($loanId)
{
    $loan = Loan::findOrFail($loanId);
    $loan->status = 'rejected';
    $loan->save();

    return redirect()->back()->with('success', 'Loan rejected.');
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

    \App\Models\LoanType::create([
        'name' => $request->name,
        'lower_limit' => $request->lower_limit,  
        'upper_limit' => $request->upper_limit,  
      ]);

    return redirect()->route('admin.dashboard')->with('success', 'Loan type added.');
}

public function analytics()
{
    $analytics = [
        'daily' => \App\Models\Loan::whereDate('created_at', today())->count(),
        'weekly' => \App\Models\Loan::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        'monthly' => \App\Models\Loan::whereMonth('created_at', now()->month)->count(),
        
    ];
    // Fetch monthly loan application counts for the last 6 months
    $monthlyTrend = Loan::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
        ->where('created_at', '>=', now()->subMonths(5)->startOfMonth()) // Get data for the last 6 months (including current)
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->map(function ($item) {
            return [
                'month_year' => \Carbon\Carbon::create($item->year, $item->month)->format('M Y'),
                'count' => $item->count,
            ];
        });
        // Fetch daily loan application trend for the last 7 days
        $dailyTrend = Loan::select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'day' => \Carbon\Carbon::parse($item->date)->format('D'),
                    'count' => $item->count,
                ];
            });

        // Fetch weekly loan application trend for the last 4 weeks
        $weeklyTrend = Loan::select(DB::raw(
            'YEARWEEK(created_at, 3) as yearweek, ' . // Use 3 to ensure Monday is the first day of the week
            'DATE_FORMAT(MIN(created_at), "%b %d") as week_start, ' .
            'DATE_FORMAT(MAX(created_at), "%b %d") as week_end, ' .
            'COUNT(*) as count'
        ))
            ->where('created_at', '>=', now()->subWeeks(3)->startOfWeek())
            ->groupBy('yearweek')
            ->orderBy('yearweek')
            ->get()
            ->map(function ($item) {
                return [
                    'week_label' => $item->week_start . ' - ' . $item->week_end,
                    'count' => $item->count,
                ];
            });
    return view('admin.analytics', compact('analytics', 'monthlyTrend', 'dailyTrend', 'weeklyTrend'));
}
}
