<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $requests = SupportRequest::with('user', 'replier')->latest()->get();
        return view('loan_officer.support', compact('requests'));
    }

    public function reply(Request $request, SupportRequest $supportRequest)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $supportRequest->update([
            'reply' => $request->input('reply'),
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);

        return redirect()->route('loan_officer.support')->with('success', 'Support request replied to successfully.');
    }
    
}