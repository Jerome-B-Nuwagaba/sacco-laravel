@extends('layouts.app')

@section('content')
<!-- Loan Analytics -->
<div>
        <h2 class="text-xl font-semibold mb-3">Loan Analytics</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-gray-100 p-4 rounded text-center shadow">
                <h3 class="font-bold text-lg">Today</h3>
                <p class="text-2xl">{{ $daily }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center shadow">
                <h3 class="font-bold text-lg">This Week</h3>
                <p class="text-2xl">{{ $weekly }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center shadow">
                <h3 class="font-bold text-lg">This Month</h3>
                <p class="text-2xl">{{ $monthly }}</p>
            </div>
        </div>
    </div>
</div>
@endsection