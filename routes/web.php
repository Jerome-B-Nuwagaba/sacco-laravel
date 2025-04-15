<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoanOfficerController;
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
    Route::get('/users', [AdminController::class, 'viewUsers'])->name('admin.users');
    Route::get('/loan-types/create', [AdminController::class, 'createLoanType'])->name('admin.loan-types.create');
    Route::post('/loan-types', [AdminController::class, 'storeLoanType'])->name('admin.loan-types.store');
    Route::get('/loans/forwarded', [AdminController::class, 'forwardedLoans'])->name('admin.loans.forwarded');
    Route::post('/loans/{id}/approve', [AdminController::class, 'approveLoan'])->name('admin.loans.approve');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
});

Route::prefix('customer')->middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::post('/customer/apply-loan', [CustomerController::class, 'applyLoan'])->name('customer.applyLoan');   
    Route::get('/loans/apply', [CustomerController::class, 'createLoan'])->name('customer.loans.apply');
    Route::post('/loans/apply', [CustomerController::class, 'storeLoan'])->name('customer.loans.store');    
    Route::get('/loans', [CustomerController::class, 'myLoans'])->name('customer.loans.index');
    Route::post('/loans/{loan_id}/pay', [CustomerController::class, 'processLoanPayment'])->name('customer.loans.pay');    
    Route::post('/payment-plans/{id}/accept', [CustomerController::class, 'acceptPaymentPlan'])->name('customer.payment-plans.accept');
});

Route::prefix('loan_officer')->middleware('auth')->group(function () {
    Route::get('/dashboard', [LoanOfficerController::class, 'index'])->name('loan_officer.dashboard');    
    Route::get('/customers', [LoanOfficerController::class, 'customers'])->name('loan_officer.customers.index');    
    Route::get('/loans/pending', [LoanOfficerController::class, 'reviewLoans'])->name('loan_officer.loans.pending');
    Route::post('/loans/{loanId}/status', [LoanOfficerController::class, 'updateLoanStatus'])->name('loan_officer.loans.update');
    //Route::post('/loans/{id}/decline', [LoanOfficerController::class, 'declineLoan'])->name('loan_officer.loans.decline');    
    Route::get('/loans/paid', [LoanOfficerController::class, 'paidLoans'])->name('loan_officer.loans.paid');    
    Route::get('/loans/{id}/payment-plan/create', [LoanOfficerController::class, 'createPaymentPlan'])->name('loan_officer.payment_plan.create');
    Route::post('/loans/payment-plan', [LoanOfficerController::class, 'storePaymentPlan'])->name('loan_officer.payment_plan.store');
});

require __DIR__.'/auth.php';
