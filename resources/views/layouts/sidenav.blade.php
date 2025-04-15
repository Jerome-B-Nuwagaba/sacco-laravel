<aside class="bg-white w-64 min-h-screen p-6 flex flex-col shadow-md">
    <div class="mb-8 flex items-center">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo" class="h-10 w-10 mr-3 rounded-full shadow">
        <h1 class="text-lg font-bold text-green-700">{{ config('app.name') }}</h1>
    </div>
    <nav class="flex-1">
        @auth
            @if (auth()->user()->role === 'admin')
                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-green-500 uppercase tracking-wider mb-3">Admin</h2>
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-tachometer-alt fa-fw mr-3 text-green-500"></i> Dashboard
                    </a>
                    <div x-data="{ open: false }" class="mt-2">
                        <button @click="open = ! open" class="w-full flex items-center justify-between py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out" aria-expanded="false" :aria-expanded="open">
                            <div class="flex items-center">
                                <i class="fas fa-users fa-fw mr-3 text-green-500"></i> <span>Users</span>
                            </div>
                            <i class="fas fa-chevron-down fa-sm text-green-500" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" class="mt-1 ml-4">
                            <a href="{{route('users.employee')}}" class="block py-2 px-4 text-green-600 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md text-sm transition duration-150 ease-in-out">Employees</a>
                            <a href="{{route('users.customer')}}" class="block py-2 px-4 text-green-600 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md text-sm transition duration-150 ease-in-out">Customers</a>
                        </div>
                    </div>
                    <a href="{{route('admin.loans.forwarded')}}" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-money-bill-wave fa-fw mr-3 text-green-500"></i> Loans
                    </a>
                    <a href="{{route('admin.analytics')}}" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-chart-bar fa-fw mr-3 text-green-500"></i> Analytics
                    </a>
                </div>
            @elseif (auth()->user()->role === 'loan_officer')
                <div class="mb-6">
                <h2 class="text-xs font-semibold text-green-500 uppercase tracking-wider mb-3">Loan Officer</h2>
                    <a href="{{ route('loan_officer.dashboard') }}" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-tachometer-alt fa-fw mr-3 text-green-500"></i> Dashboard
                    </a>
                    
                    <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-file-alt fa-fw mr-3 text-green-500"></i> Loan Applications
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-hand-holding-usd fa-fw mr-3 text-green-500"></i> My Loans
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-credit-card fa-fw mr-3 text-green-500"></i> Manage Payments
                    </a>
                </div>
            @elseif (auth()->user()->role === 'customer')
                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-green-500 uppercase tracking-wider mb-3">Customer</h2>
                    <a href="{{ route('loan_officer.dashboard') }}" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-tachometer-alt fa-fw mr-3 text-green-500"></i> Dashboard
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-paper-plane fa-fw mr-3 text-green-500"></i> Apply for Loan
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-info-circle fa-fw mr-3 text-green-500"></i> Loan Status
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-bell fa-fw mr-3 text-green-500"></i> Payment Notifications
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-headset fa-fw mr-3 text-green-500"></i> Contact Support
                    </a>
                </div>
            @endif

            <div class="mt-auto">
                <h2 class="text-xs font-semibold text-green-500 uppercase tracking-wider mb-3">General</h2>
                <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out">
                    <i class="fas fa-cog fa-fw mr-3 text-green-500"></i> Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-sign-out-alt fa-fw mr-3 text-green-500"></i> Logout
                    </button>
                </form>
            </div>
        @endauth
    </nav>
</aside>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            open: false,
        }));
    });
</script>