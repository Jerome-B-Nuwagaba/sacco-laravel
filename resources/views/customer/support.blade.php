@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Contact Support</h1>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-10">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Talk to support </h2>
        @if(session('support_success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-200 dark:border-green-700">
                {{ session('support_success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('customer.support.submit') }}">
            @csrf
            <input type="hidden" name="email" value="{{ auth()->user()->email }}">

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                <textarea
                    id="message"
                    name="message"
                    rows="5"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
            </div>

            <button
                type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
                Submit
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Replies to Your Messages</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Message Sent</th>
                        <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Your Message</th>
                        <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Reply</th>
                        <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Replied By</th>
                    </tr>
                </thead>
<!--replies-->
                <tbody>
                    @forelse ($replies as $reply)
                        <tr class="{{ $loop->even ? 'bg-gray-50 dark:bg-gray-800/50' : 'bg-white dark:bg-gray-800' }}">
                            <td class="py-2 px-4">{{ $reply->created_at->format('d M, Y H:i') }}</td>
                            <td class="py-2 px-4">{{ $reply->message }}</td>
                            <td class="py-2 px-4">
                                @if ($reply->reply)
                                    <p class="text-green-600 dark:text-green-400">{{ $reply->reply }}</p>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">No reply yet.</p>
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $reply->replier->name ?? 'N/A' }}</td>
                                </tr>
                    @empty
                        <tr><td class="py-4 px-4 text-center" colspan="5">No replies to your messages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Frequently Asked Questions</h2>
        <div class="space-y-4">
            <div>
                <h3 class="font-medium text-gray-700 dark:text-gray-300">How long does it take to process a loan?</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Loan processing typically takes 1-3 business days once all requirements are fulfilled.</p>
            </div>
            <div>
                <h3 class="font-medium text-gray-700 dark:text-gray-300">Can I pay my loan before the due date?</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Yes, you can make payments anytime as long as your plan is active.</p>
            </div>
            <div>
                <h3 class="font-medium text-gray-700 dark:text-gray-300">What happens if I miss a payment?</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Missing a payment may result in penalties or delays in future loans. Please contact support for assistance.</p>
            </div>
        </div>
    </div>
</div>
@endsection