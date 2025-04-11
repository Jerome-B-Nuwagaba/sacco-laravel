<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanOfficerController extends Controller
{
    public function index()
    {
        return view('loan-officer.dashboard');
    }
}
