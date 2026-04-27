<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MLPredictionService;

class LoanAssessmentController extends Controller
{
    public function __construct(private MLPredictionService $ml) {}

    public function showForm()
    {
        return view('loan_officer.assess');
    }

    public function assess(Request $request)
    {
        $data = $request->validate([
            'age'                => 'required|integer|min:18|max:80',
            'membership_years'   => 'required|integer|min:0',
            'annual_income_ugx'  => 'required|integer|min:0',
            'annual_savings_ugx' => 'required|integer|min:0',
            'loan_amount_ugx'    => 'required|integer|min:100000',
            'land_size_acres'    => 'required|numeric|min:0',
            'collateral_ugx'     => 'required|integer|min:0',
            'num_guarantors'     => 'required|integer|min:0',
            'emp_length_years'   => 'required|numeric|min:0',
            'primary_crop'       => 'required|string',
            'home_ownership'     => 'required|string',
            'loan_grade'         => 'required|in:A,B,C,D,E,F,G',
            'loan_purpose'       => 'required|string',
            'interest_rate_pct'  => 'required|numeric|min:0',
            'loan_pct_income'    => 'required|numeric|min:0',
            'credit_hist_years'  => 'required|integer|min:0',
            'prior_default_num'  => 'required|in:0,1',
            'profitability_2022' => 'required|integer|min:1|max:5',
            'profitability_2023' => 'required|integer|min:1|max:5',
            'soil_acidity'       => 'required|integer|min:1|max:5',
            'rainfall_2022_mm'   => 'required|numeric|min:0',
            'rainfall_2023_mm'   => 'required|numeric|min:0',
            'temperature_c'      => 'required|numeric',
            'humidity'           => 'required|numeric|min:0|max:100',
            'wind_speed'         => 'required|numeric|min:0',
            'weather_desc'       => 'required|string',
            'district'           => 'required|string',
            'region'             => 'required|string',
            'total_rainfall_mm'  => 'required|numeric|min:0',
            'avg_temp_c'         => 'required|numeric',
            'drought_flag'       => 'required|in:0,1',
            'flood_risk_flag'    => 'required|in:0,1',
            'weather_risk_score' => 'required|numeric|min:0|max:10',
        ]);

        $prediction = $this->ml->predict($data);

        if (!$prediction) {
            return back()
                ->with('error', 'ML service is unavailable. Please try again shortly.')
                ->withInput();
        }

        // Pass both the submitted data and the prediction to the results view
        return view('loan_officer.results', [
            'input'      => $data,
            'prediction' => $prediction,
        ]);
    }
}
