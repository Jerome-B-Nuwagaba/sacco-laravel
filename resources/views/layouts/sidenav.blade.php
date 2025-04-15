<aside class="bg-gray-100 w-64 min-h-screen p-4">
<div class="mb-4 flex items-center">
    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo" class="h-8 w-auto mr-2 rounded-full">
    <h1 class="text-xl font-semibold text-gray-800">{{ config('app.name') }}</h1>
</div>
    <nav>
        @auth
            @if (auth()->user()->role === 'admin')
                <div class="mb-2">
                    <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Admin</h2>
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <div x-data="{ open: false }" class="mb-2">
                        <button @click="open = ! open" class="w-full flex items-center justify-between py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i> <span>Users</span>
                            </div>
                            <i class="fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" class="mt-1 ml-4">
                            <a href="{{route('users.employee')}}" class="block py-2 px-4 text-gray-600 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">Employees</a>
                            <a href="{{route('users.customer')}}" class="block py-2 px-4 text-gray-600 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">Customers</a>
                        </div>
                    </div>
                    <a href="{{route('admin.loans.forwarded')}}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-money-bill-wave mr-2"></i> Loans
                    </a>
                    <a href="{{route('admin.analytics')}}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-chart-bar mr-2"></i> Analytics
                    </a>
                </div>
            @elseif (auth()->user()->role === 'loan_officer')
                <div class="mb-2">
                    <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Loan Officer</h2>
                    <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-file-alt mr-2"></i> Loan Applications
                    </a>
                    <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-hand-holding-usd mr-2"></i> My Loans
                    </a>
                    <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-credit-card mr-2"></i> Manage Payments
                    </a>
                </div>
            @elseif (auth()->user()->role === 'customer')
                <div class="mb-2">
                    <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Customer</h2>
                    <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-paper-plane mr-2"></i> Apply for Loan
                    </a>
                    <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-info-circle mr-2"></i> Loan Status
                    </a>
                    <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-bell mr-2"></i> Payment Notifications
                    </a>
                    <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                        <i class="fas fa-headset mr-2"></i> Contact Support
                    </a>
                </div>
            @endif

            <div class="mt-4">
                <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">General</h2>
                <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full text-left py-2 px-4 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 rounded-md">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
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