@extends('layouts.app')

@section('content')


    <!-- Accept Payment Plan -->
    <div>
        <h2 class="text-xl font-semibold mb-2">Payment Plans</h2>
        @forelse ($paymentPlans as $plan)
            <div class="bg-white p-4 border mb-4 rounded">
                <p><strong>Installment Amount:</strong> {{ $plan->amount_per_installment }}</p>
                <p><strong>Number of Installments:</strong> {{ $plan->number_of_installments }}</p>
                <p><strong>Completion Date:</strong> {{ $plan->completion_date }}</p>
                <form action="{{ route('customer.payment-plans.accept', $plan->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept Plan</button>
                </form>
            </div>
        @empty
            <p>No payment plans yet.</p>
        @endforelse
    </div>
</div>
@endsection