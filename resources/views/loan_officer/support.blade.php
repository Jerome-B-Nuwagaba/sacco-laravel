@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4 text-gray-200 dark:text-gray-100">Support Requests</h2>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-700 dark:bg-gray-800 shadow-md rounded-lg">
            <thead class="bg-gray-600 dark:bg-gray-700 text-gray-200 dark:text-gray-300">
                <tr>
                    <th class="py-2 px-4 text-left font-semibold">ID</th>
                    <th class="py-2 px-4 text-left font-semibold">User</th>
                    <th class="py-2 px-4 text-left font-semibold">Email</th>
                    <th class="py-2 px-4 text-left font-semibold">Message</th>
                    <th class="py-2 px-4 text-left font-semibold">Created At</th>
                    <th class="py-2 px-4 text-left font-semibold">Reply</th>
                    <th class="py-2 px-4 text-left font-semibold">Replied By</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr class="{{ $loop->even ? 'bg-gray-800/50 dark:bg-gray-800/75' : 'bg-gray-700 dark:bg-gray-800' }} text-gray-300 dark:text-gray-100">
                        <td class="py-2 px-4">{{ $request->id }}</td>
                        <td class="py-2 px-4">{{ $request->user->name ?? 'Guest' }}</td>
                        <td class="py-2 px-4">{{ $request->email }}</td>
                        <td class="py-2 px-4">{{ $request->message }}</td>
                        <td class="py-2 px-4">{{ $request->created_at->format('d M, Y H:i') }}</td>
                        <td class="py-2 px-4">
                            @if ($request->reply)
                                <p class="text-green-400 dark:text-green-300">{{ $request->reply }}</p>
                                <p class="text-sm text-blue-400 dark:text-blue-300">By: {{ $request->replier->name ?? 'N/A' }}</p>
                            @else
                                <form action="{{ route('loan_officer.support.reply', $request->id) }}" method="POST">
                                    @csrf
                                    <textarea name="reply" class="w-full border rounded p-2 bg-gray-800 dark:bg-gray-700 border-gray-600 text-gray-300 dark:text-gray-100" rows="3" placeholder="Enter your reply"></textarea>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Reply</button>
                                </form>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $request->replier->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr><td class="py-4 px-4 text-center text-gray-400 dark:text-gray-300" colspan="7">No support requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection