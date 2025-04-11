<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function showRegistrationForm()
    {
        $companies = Company::all();
        return view('auth.register', compact('companies'));
    }
}
