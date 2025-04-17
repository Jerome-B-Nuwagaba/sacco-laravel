<aside class="bg-white w-64 min-h-screen p-6 flex flex-col shadow-md" :class="{'dark:bg-gray-900 dark:text-gray-100': darkMode}">
    <div class="mb-8 flex items-center">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo" class="h-10 w-10 mr-3 rounded-full shadow">
        <h1 class="text-lg font-bold text-green-700 dark:text-green-500">{{ config('app.name') }}</h1>
    </div>
    <nav class="flex-1">
        @auth
            @if (auth()->user()->role === 'admin')
                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-green-500 dark:text-green-400 uppercase tracking-wider mb-3">Admin</h2>
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-tachometer-alt fa-fw mr-3 text-green-500 dark:text-green-400"></i> Dashboard
                    </a>
                    <div x-data="{ open: false }" class="mt-2">
                        <button @click="open = ! open" class="w-full flex items-center justify-between py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md transition duration-150 ease-in-out" aria-expanded="false" :aria-expanded="open">
                            <div class="flex items-center">
                                <i class="fas fa-users fa-fw mr-3 text-green-500 dark:text-green-400"></i> <span>Users</span>
                            </div>
                            <i class="fas fa-chevron-down fa-sm text-green-500 dark:text-green-400" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" class="mt-1 ml-4">
                            <a href="{{route('users.employee')}}" class="block py-2 px-4 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md text-sm transition duration-150 ease-in-out">Employees</a>
                            <a href="{{route('users.customer')}}" class="block py-2 px-4 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md text-sm transition duration-150 ease-in-out">Customers</a>
                        </div>
                    </div>
                    <a href="{{route('admin.loans.forwarded')}}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-money-bill-wave fa-fw mr-3 text-green-500 dark:text-green-400"></i> Loans
                    </a>
                    <a href="{{route('admin.analytics')}}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-chart-bar fa-fw mr-3 text-green-500 dark:text-green-400"></i> Analytics
                    </a>
                </div>
            @elseif (auth()->user()->role === 'loan_officer')
                <div class="mb-6">
                <h2 class="text-xs font-semibold text-green-500 dark:text-green-400 uppercase tracking-wider mb-3">Loan Officer</h2>
                    <a href="{{ route('loan_officer.dashboard') }}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-tachometer-alt fa-fw mr-3 text-green-500 dark:text-green-400"></i> Dashboard
                    </a>

                    <a href="{{route('loan_officer.loans.pending')}}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-file-alt fa-fw mr-3 text-green-500 dark:text-green-400"></i> Loan Applications
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-hand-holding-usd fa-fw mr-3 text-green-500 dark:text-green-400"></i> My Loans
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-credit-card fa-fw mr-3 text-green-500 dark:text-green-400"></i> Manage Payments
                    </a>
                </div>
            @elseif (auth()->user()->role === 'customer')
                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-green-500 dark:text-green-400 uppercase tracking-wider mb-3">Customer</h2>
                    <a href="{{ route('customer.dashboard') }}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-tachometer-alt fa-fw mr-3 text-green-500 dark:text-green-400"></i> Dashboard
                    </a>
                    <a href="{{route('customer.loans.index')}}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md mt-2 transition duration-150 ease-in-out">
                    <i class="fas fa-money-bill-wave fa-fw mr-3 text-green-500 dark:text-green-400"></i> My Loans
                    </a>
                    <a href="{{route('customer.payments')}}" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-credit-card fa-fw mr-3 text-green-500 dark:text-green-400"></i> Payments
                    </a>
                    <a href="#" class="block py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md mt-2 transition duration-150 ease-in-out">
                        <i class="fas fa-headset fa-fw mr-3 text-green-500 dark:text-green-400"></i> Contact Support
                    </a>
                </div>
            @endif

            <div class="mt-auto">
                <h2 class="text-xs font-semibold text-green-500 dark:text-green-400 uppercase tracking-wider mb-3">General</h2>
                <button
                @click="darkMode = !darkMode; applyTheme()"
                class="w-full flex items-center py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 rounded-md transition"
                >
                <i class="fas fa-adjust fa-fw mr-3 text-green-500 dark:text-green-400"></i>
                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                </button>


                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-green-100 dark:focus:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-sign-out-alt fa-fw mr-3 text-green-500 dark:text-green-400"></i> Logout
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

        Alpine.data('themeSwitcher', () => ({
            darkMode: localStorage.getItem('darkMode') === 'true' || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches),
            init() {
                this.applyTheme();
                $watch('darkMode', value => {
                    localStorage.setItem('darkMode', value);
                    this.applyTheme();
                });
            },
            applyTheme() {
                document.documentElement.classList.toggle('dark', this.darkMode);
            }
        }));
    });
</script>