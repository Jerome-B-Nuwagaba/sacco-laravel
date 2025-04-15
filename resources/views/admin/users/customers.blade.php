@extends('layouts.app')

@section('content')
<!-- Registered Customers -->
 <div class="mb-10">
        <h2 class="text-xl font-semibold mb-3">Customers</h2>
        @forelse ($customers as $customer)
            <div class="bg-white p-4 mb-3 rounded shadow">
                <p><strong>Name:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Company:</strong> {{ $customer->company->name }}</p>
            </div>
        @empty
            <p>No customers registered yet.</p>
        @endforelse
    </div>
@endsection