<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $redirectRoutes = [
            'admin' => 'admin.dashboard',
            'loan_officer' => 'loan_officer.dashboard',
            'customer' => 'customer.dashboard',
        ];
    
        
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route($redirectRoutes[$user->role], absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
