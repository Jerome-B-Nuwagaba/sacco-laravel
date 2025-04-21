@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Support Requests</h2>

    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">ID</th>
                    <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">User</th>
                    <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Email</th>
                    <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Message</th>
                    <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Created At</th>
                    <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Reply</th>
                    <th class="py-2 px-4 text-left font-semibold text-gray-700 dark:text-gray-300">Replied By</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr class="{{ $loop->even ? 'bg-gray-50 dark:bg-gray-800/50' : 'bg-white dark:bg-gray-800' }}">
                        <td class="py-2 px-4">{{ $request->id }}</td>
                        <td class="py-2 px-4">{{ $request->user->name ?? 'Guest' }}</td>
                        <td class="py-2 px-4">{{ $request->email }}</td>
                        <td class="py-2 px-4">{{ $request->message }}</td>
                        <td class="py-2 px-4">{{ $request->created_at->format('d M, Y H:i') }}</td>
                        <td class="py-2 px-4">
                            @if ($request->reply)
                                <p class="text-green-600 dark:text-green-400">{{ $request->reply }}</p>
                                <p class="text-sm text-blue-500 dark:text-blue-400">By: {{ $request->replier->name ?? 'N/A' }}</p>
                            @else
                                <form action="{{ route('loan_officer.support.reply', $request->id) }}" method="POST">
                                    @csrf
                                    <textarea name="reply" class="w-full border rounded p-2 text-gray-800 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" rows="3" placeholder="Enter your reply"></textarea>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Reply</button>
                                </form>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $request->replier->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr><td class="py-4 px-4 text-center" colspan="7">No support requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection