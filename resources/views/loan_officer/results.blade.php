@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
        ML Assessment Result
    </h2>
    <p class="text-gray-500 dark:text-gray-400">
        Based on the submitted member profile.
    </p>
</div>

{{-- RISK LEVEL --}}
@php
    $riskStyles = match($prediction['risk_level']) {
        'Low'    => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
        'Medium' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
        'High'   => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
        default  => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
    };
@endphp

<div class="mb-6 p-4 rounded-lg {{ $riskStyles }}">
    <div class="font-semibold text-lg">
        Risk Level: {{ $prediction['risk_level'] }}
    </div>
    <div class="text-sm mt-1">
        Low {{ number_format($prediction['risk_probabilities']['Low'] * 100, 1) }}% |
        Medium {{ number_format($prediction['risk_probabilities']['Medium'] * 100, 1) }}% |
        High {{ number_format($prediction['risk_probabilities']['High'] * 100, 1) }}%
    </div>
</div>

{{-- UNCERTAINTY --}}
@if($prediction['uncertainty_warning'])
    <div class="mb-6 p-4 rounded-lg bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">
        <strong>Confidence warning:</strong> {{ $prediction['uncertainty_warning'] }}
    </div>
@endif

{{-- KEY METRICS --}}
<div class="grid md:grid-cols-3 gap-4 mb-8">

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center">
        <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Credit Score</div>
        <div class="text-3xl font-semibold text-gray-800 dark:text-gray-100">
            {{ number_format($prediction['credit_score'], 1) }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Internal relative score</div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center">
        <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Recommended Max Loan</div>
        <div class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            UGX {{ number_format($prediction['recommended_loan_ugx']) }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Requested: UGX {{ number_format($input['loan_amount_ugx']) }}
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center">
        <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">DTI Limit</div>
        <div class="text-3xl font-semibold">
            @if($prediction['loan_within_dti_limit'])
                <span class="text-green-600 dark:text-green-400">Pass</span>
            @else
                <span class="text-red-600 dark:text-red-400">Fail</span>
            @endif
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max allowed: 40%</div>
    </div>

</div>

{{-- POLICY FLAGS --}}
@if(count($prediction['policy_flags']) > 0)
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg mb-8 border border-red-500">
        <div class="px-6 py-3 bg-red-500 text-white font-semibold rounded-t-lg">
            Policy Flags ({{ count($prediction['policy_flags']) }})
        </div>
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($prediction['policy_flags'] as $flag)
                <li class="px-6 py-3 text-red-600 dark:text-red-400">{{ $flag }}</li>
            @endforeach
        </ul>
    </div>
@else
    <div class="mb-8 p-4 rounded-lg bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
        No policy flags raised.
    </div>
@endif

{{-- PROFILE SUMMARY --}}
<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
        Submitted Profile Summary
    </h3>
    <div class="grid md:grid-cols-3 gap-2 text-sm">
        @foreach($input as $key => $value)
            <div>
                <span class="text-gray-500 dark:text-gray-400">
                    {{ str_replace('_', ' ', ucfirst($key)) }}:
                </span>
                <span class="font-semibold text-gray-800 dark:text-gray-100">
                    {{ $value }}
                </span>
            </div>
        @endforeach
    </div>
</div>

<!-- ACTION -->
<a href="{{ route('loan_officer.assess') }}"
   class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
    Run Another Assessment
</a>


</div>

@endsection