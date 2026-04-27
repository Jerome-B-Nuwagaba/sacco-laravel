@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
        SACCO Loan Intelligence Assessment
    </h2>
    <p class="text-gray-500 dark:text-gray-400">
        Enter member and loan details to receive an ML-generated risk assessment.
    </p>
</div>

@if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">
        {{ session('error') }}
    </div>
@endif

{{-- Show ALL validation errors at the top so nothing fails silently --}}
@if($errors->any())
    <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">
        <p class="font-semibold mb-2">Please fix the following errors:</p>
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('loan_officer.assess.submit') }}">
@csrf

{{-- ── MEMBER PROFILE ────────────────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Member Profile</h3>
    <div class="grid md:grid-cols-3 gap-4">

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Age</label>
            <input type="number" name="age" value="{{ old('age', 35) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Membership Years</label>
            <input type="number" name="membership_years" value="{{ old('membership_years', 5) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Employment Length (years)</label>
            <input type="number" step="0.5" name="emp_length_years" value="{{ old('emp_length_years', 6) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Annual Income (UGX)</label>
            <input type="number" name="annual_income_ugx" value="{{ old('annual_income_ugx', 9600000) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Annual Savings (UGX)</label>
            <input type="number" name="annual_savings_ugx" value="{{ old('annual_savings_ugx', 1200000) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Home Ownership</label>
            <select name="home_ownership"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach(['OWN','RENT','MORTGAGE','OTHER'] as $opt)
                    <option value="{{ $opt }}" {{ old('home_ownership','OWN')==$opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Credit History (years)</label>
            <input type="number" name="credit_hist_years" value="{{ old('credit_hist_years', 5) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Prior Default</label>
            <select name="prior_default_num"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <option value="0" {{ old('prior_default_num','0')=='0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('prior_default_num','0')=='1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Number of Guarantors</label>
            <input type="number" name="num_guarantors" value="{{ old('num_guarantors', 3) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

    </div>
</div>

{{-- ── LOAN DETAILS ──────────────────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Loan Details</h3>
    <div class="grid md:grid-cols-3 gap-4">

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Requested Loan Amount (UGX)</label>
            <input type="number" name="loan_amount_ugx" value="{{ old('loan_amount_ugx', 3000000) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Loan Grade</label>
            <select name="loan_grade"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach(['A','B','C','D','E','F','G'] as $g)
                    <option value="{{ $g }}" {{ old('loan_grade','B')==$g ? 'selected' : '' }}>{{ $g }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Loan Purpose</label>
            <select name="loan_purpose"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach(['AGRICULTURE','PERSONAL','EDUCATION','MEDICAL','BUSINESS','HOMEIMPROVEMENT'] as $p)
                    <option value="{{ $p }}" {{ old('loan_purpose','AGRICULTURE')==$p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Interest Rate (%)</label>
            <input type="number" step="0.1" name="interest_rate_pct" value="{{ old('interest_rate_pct', 13.5) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Loan as % of Income (0–1)</label>
            <input type="number" step="0.01" name="loan_pct_income" value="{{ old('loan_pct_income', 0.31) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Collateral Value (UGX)</label>
            <input type="number" name="collateral_ugx" value="{{ old('collateral_ugx', 8000000) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

    </div>
</div>

{{-- ── FARM DETAILS ──────────────────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Farm Details</h3>
    <div class="grid md:grid-cols-3 gap-4">

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Primary Crop</label>
            <select name="primary_crop"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach(['Maize','Beans','Coffee','Cotton','Banana','Cassava','Rice','Sorghum','Sunflower','Tea','Tobacco','Wheat'] as $c)
                    <option value="{{ $c }}" {{ old('primary_crop','Maize')==$c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Land Size (acres)</label>
            <input type="number" step="0.1" name="land_size_acres" value="{{ old('land_size_acres', 4.0) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Soil Acidity (1=Very Acidic, 5=Alkaline)</label>
            <select name="soil_acidity"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach([1,2,3,4,5] as $s)
                    <option value="{{ $s }}" {{ old('soil_acidity',3)==$s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Profitability 2022 (1–5)</label>
            <select name="profitability_2022"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach([1,2,3,4,5] as $p)
                    <option value="{{ $p }}" {{ old('profitability_2022',3)==$p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Profitability 2023 (1–5)</label>
            <select name="profitability_2023"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach([1,2,3,4,5] as $p)
                    <option value="{{ $p }}" {{ old('profitability_2023',4)==$p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Rainfall 2022 (mm)</label>
            <input type="number" name="rainfall_2022_mm" value="{{ old('rainfall_2022_mm', 820) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Rainfall 2023 (mm)</label>
            <input type="number" name="rainfall_2023_mm" value="{{ old('rainfall_2023_mm', 890) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

    </div>
</div>

{{-- ── WEATHER & LOCATION ────────────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Weather & Location</h3>
    <div class="grid md:grid-cols-3 gap-4">

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">District</label>
            <select name="district"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach(['Arua','Gulu','Hoima','Jinja','Kabale','Kampala','Kasese','Lira','Masaka','Mbarara','Mbale','Mukono','Soroti','Tororo','Wakiso'] as $d)
                    <option value="{{ $d }}" {{ old('district','Gulu')==$d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Region</label>
            <select name="region"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach(['Central','Eastern','Northern','Western'] as $r)
                    <option value="{{ $r }}" {{ old('region','Northern')==$r ? 'selected' : '' }}>{{ $r }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Weather Description</label>
            <select name="weather_desc"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                @foreach(['Clear','Sunny','Cloudy','Rainy','Stormy'] as $w)
                    <option value="{{ $w }}" {{ old('weather_desc','Clear')==$w ? 'selected' : '' }}>{{ $w }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Temperature (°C)</label>
            <input type="number" step="0.1" name="temperature_c" value="{{ old('temperature_c', 27) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Humidity (%)</label>
            <input type="number" name="humidity" value="{{ old('humidity', 65) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Wind Speed</label>
            <input type="number" name="wind_speed" value="{{ old('wind_speed', 8) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Seasonal Rainfall (mm)</label>
            <input type="number" name="total_rainfall_mm" value="{{ old('total_rainfall_mm', 890) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Avg Season Temp (°C)</label>
            <input type="number" step="0.1" name="avg_temp_c" value="{{ old('avg_temp_c', 27.0) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Weather Risk Score (0–10)</label>
            <input type="number" step="0.1" name="weather_risk_score" value="{{ old('weather_risk_score', 1.5) }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Drought Flag</label>
            <select name="drought_flag"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <option value="0" {{ old('drought_flag','0')=='0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('drought_flag','0')=='1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Flood Risk Flag</label>
            <select name="flood_risk_flag"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <option value="0" {{ old('flood_risk_flag','0')=='0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('flood_risk_flag','0')=='1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

    </div>
</div>

<button type="submit"
    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg shadow transition">
    Run ML Assessment
</button>

</form>

@endsection