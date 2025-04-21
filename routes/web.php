<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoanOfficerController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    $redirectRoutes = [
        'admin' => 'admin.dashboard',
        'loan_officer' => 'loan_officer.dashboard',
        'customer' => 'customer.dashboard',
    ];

    return redirect()->route($redirectRoutes[$user->role]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/loan_officer/dashboard', [LoanOfficerController::class, 'index'])->name('loanofficer.dashboard');
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->name('customerdashboard.dashboards');

});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/users/employees', [AdminController::class, 'viewEmployees'])->name('users.employee');
    Route::get('/users/customers', [AdminController::class, 'viewCustomers'])->name('users.customer');
    Route::get('/loan-types/create', [AdminController::class, 'createLoanType'])->name('admin.loan-types.create');
    Route::post('/loan-types', [AdminController::class, 'storeLoanType'])->name('admin.loan-types.store');
    Route::get('/loans/forwarded', [AdminController::class, 'forwardedLoans'])->name('admin.loans.forwarded');
    Route::post('/loans/{id}/approve', [AdminController::class, 'approveLoan'])->name('admin.loans.approve');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
});

Route::prefix('customer')->middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::post('/apply-loan', [CustomerController::class, 'applyLoan'])->name('customer.applyLoan');   
    Route::get('/loans/apply', [CustomerController::class, 'createLoan'])->name('customer.loans.apply');
    Route::post('/loans/apply', [CustomerController::class, 'storeLoan'])->name('customer.loans.store');    
    Route::get('/myloans', [CustomerController::class, 'myLoans'])->name('customer.loans.index');
    Route::get('/payments', [CustomerController::class, 'viewPaymentPlans'])->name('customer.payments');
    Route::get('/pay-loan/{loanId}', [CustomerController::class, 'showPayLoan'])->name('customer.payLoan');
    Route::post('/loans/{loan}/pay', [CustomerController::class, 'processLoanPayment'])->name('customer.loans.pay');    
    Route::post('/payment-plans/{id}/accept', [CustomerController::class, 'acceptPaymentPlan'])->name('customer.payment-plans.accept');
    Route::delete('/reject-plan/{id}', [CustomerController::class, 'rejectPaymentPlan'])->name('customer.rejectPlan');
    Route::get('/support', [CustomerController::class, 'supportPage'])->name('customer.support');
    Route::post('/support', [CustomerController::class, 'submitSupportRequest'])->name('customer.support.submit');
});

Route::prefix('loan_officer')->middleware('auth')->group(function () {
    Route::get('/dashboard', [LoanOfficerController::class, 'dashboard'])->name('loan_officer.dashboard');    
    Route::get('/customers', [LoanOfficerController::class, 'customers'])->name('loan_officer.customers.index');    
    Route::get('/loan-applications', [LoanOfficerController::class, 'reviewLoans'])->name('loan_officer.loans.pending');
    //Route::post('loans/{loan}/assign', [LoanOfficerController::class, 'assignLoanOfficer'])->name('loan_officer.assign_loan');
    Route::get('/loans/{loan}/details', [LoanOfficerController::class, 'showDetails'])->name('loan_officer.loans.details');
    Route::get('/loans/{id}/forward', [LoanOfficerController::class, 'forwardLoan'])->name('loan_officer.loans.forward');
    Route::post('/loans/{loanId}/status', [LoanOfficerController::class, 'updateLoanStatus'])->name('loan_officer.loans.update');
    Route::post('loan_officer/manage_user/{user}', [LoanOfficerController::class, 'manageUser'])->name('loan_officer.manage_user');
Route::get('loan_officer/loans/{loan}', [LoanOfficerController::class, 'show'])->name('loan_officer.loans.show');
    Route::get('/loans/paid', [LoanOfficerController::class, 'paidLoans'])->name('loan_officer.loans.paid');       
    Route::get('/loans/payment-plan/create', [LoanOfficerController::class, 'createPaymentPlan'])->name('loan_officer.payment_plan.create');
    Route::post('/loans/payment-plan', [LoanOfficerController::class, 'storePaymentPlan'])->name('loan_officer.payment_plan.store');
    Route::get('/payment-plans/{loan}', [LoanOfficerController::class, 'showPaymentPlan'])->name('loan_officer.payment_plan.show');
    Route::get('/loans/{id}/details', [LoanOfficerController::class, 'loanDetails'])->name('loan_officer.loans.details');
    Route::get('/support', [SupportController::class, 'index'])->name('loan_officer.support');
    Route::post('/support/{supportRequest}/reply', [SupportController::class, 'reply'])->name('loan_officer.support.reply');
});

require __DIR__.'/auth.php';
