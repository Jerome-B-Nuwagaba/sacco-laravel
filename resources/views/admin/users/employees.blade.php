@extends('layouts.app')

@section('content')
<!-- Registered Loan Officers -->
<div class="mb-10">
        <h2 class="text-xl font-semibold mb-3">Loan Officers</h2>
        @forelse ($loanOfficers as $officer)
            <div class="bg-white p-4 mb-3 rounded shadow">
                <p><strong>Name:</strong> {{ $officer->name }}</p>
                <p><strong>Email:</strong> {{ $officer->email }}</p>
            </div>
        @empty
            <p>No loan officers registered yet.</p>
        @endforelse
    </div>

    @endsection