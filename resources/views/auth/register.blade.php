<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Create Account</h1>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input 
                id="name" 
                class="w-full mt-1" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                placeholder="Your full name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
                id="email" 
                class="w-full mt-1" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                placeholder="your-email@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Company Dropdown -->
        <div>
            <x-input-label for="company_id" :value="__('Company')" />
            <select 
                name="company_id" 
                id="company_id" 
                class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                required
            >
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input 
                id="password" 
                class="w-full mt-1" 
                type="password" 
                name="password" 
                required 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input 
                id="password_confirmation" 
                class="w-full mt-1" 
                type="password" 
                name="password_confirmation" 
                required 
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div>
    <x-input-label :value="__('Select Role')" />
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mt-2">
        @foreach(['admin', 'loan_officer', 'customer'] as $role)
            <button 
                type="button"
                data-role="{{ $role }}"
                onclick="toggleRole(this)"
                class="p-3 text-left rounded-md border border-gray-300 hover:border-green-500 transition-colors {{ old('role') == $role ? 'bg-green-500 text-white border-green-600' : 'bg-white' }}"
            >
                <span class="capitalize">{{ str_replace('_', ' ', $role) }}</span>
            </button>
        @endforeach
    </div>
    <input type="hidden" name="role" id="selectedRole" value="{{ old('role') }}" required>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-800 transition-colors">
            Create Account
        </button>

        <p class="text-center mt-4 text-gray-600 dark:text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-green-500 hover:underline">Log in</a>
        </p>
    </form>
    <script>
    function toggleRole(button) {
        const selectedRoleInput = document.getElementById('selectedRole');
        const currentlySelectedRole = selectedRoleInput.value;
        const clickedRole = button.dataset.role;

        // Remove active styles from all buttons
        document.querySelectorAll('[data-role]').forEach(btn => {
            btn.classList.remove('bg-green-500', 'text-white', 'border-green-600');
            btn.classList.add('bg-white', 'border-gray-300');
        });

        // If the clicked button was already selected, unselect it
        if (currentlySelectedRole === clickedRole) {
            selectedRoleInput.value = ''; // Clear the hidden input
        } else {
            // Add active styles to the clicked button
            button.classList.add('bg-green-500', 'text-white', 'border-green-600');
            button.classList.remove('bg-white', 'border-gray-300');
            // Update hidden input value
            selectedRoleInput.value = clickedRole;
        }
    }

    // Initialize with existing value
    document.addEventListener('DOMContentLoaded', function() {
        const selectedRole = document.getElementById('selectedRole').value;
        if(selectedRole) {
            const activeBtn = document.querySelector(`[data-role="${selectedRole}"]`);
            if(activeBtn) {
                activeBtn.classList.add('bg-green-500', 'text-white', 'border-green-600');
                activeBtn.classList.remove('bg-white', 'border-gray-300');
            }
        }
    });
</script>
</x-guest-layout>