<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();
        $redirectRoutes = [
            'admin' => 'admin.dashboard',
            'loan_officer' => 'loan_officer.dashboard',
            'customer' => 'customer.dashboard',
        ];

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route($redirectRoutes[$user->role], absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route($redirectRoutes[$user->role], absolute: false).'?verified=1');
    }
}
