<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();
        $redirectRoutes = [
            'admin' => 'admin.dashboard',
            'loan_officer' => 'loan_officer.dashboard',
            'customer' => 'customer.dashboard',
        ];
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route($redirectRoutes[$user->role], absolute: false))
                    : view('auth.verify-email');
    }
}
