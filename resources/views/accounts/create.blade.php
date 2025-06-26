<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('accounts.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Account') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                <form method="POST" action="{{ route('accounts.store') }}" class="p-6 space-y-6">
                    @csrf

                    <!-- Account Name -->
                    <div>
                        <x-input-label for="name" :value="__('Account Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                      :value="old('name')" required autofocus autocomplete="name" 
                                      placeholder="e.g., Main Checking, Emergency Savings" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose a descriptive name to easily identify this account.</p>
                    </div>

                    <!-- Account Type -->
                    <div>
                        <x-input-label for="type" :value="__('Account Type')" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="">Select account type</option>
                            <option value="checking" {{ old('type') == 'checking' ? 'selected' : '' }}>
                                🏦 Checking Account
                            </option>
                            <option value="savings" {{ old('type') == 'savings' ? 'selected' : '' }}>
                                💰 Savings Account
                            </option>
                            <option value="cash" {{ old('type') == 'cash' ? 'selected' : '' }}>
                                💵 Cash
                            </option>
                            <option value="credit" {{ old('type') == 'credit' ? 'selected' : '' }}>
                                💳 Credit Card
                            </option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <!-- Initial Balance -->
                    <div>
                        <x-input-label for="initial_balance" :value="__('Initial Balance')" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">¥</span>
                            </div>
                            <x-text-input id="initial_balance" name="initial_balance" type="number" 
                                          class="block w-full pl-7" step="0.01" :value="old('initial_balance', '0')" 
                                          required placeholder="0.00" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('initial_balance')" />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter the current balance of this account. For credit cards, enter the balance as a positive number (it will be displayed as negative).</p>
                    </div>

                    <!-- Currency -->
                    <div>
                        <x-input-label for="currency" :value="__('Currency')" />
                        <select id="currency" name="currency" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="JPY" {{ old('currency', 'JPY') == 'JPY' ? 'selected' : '' }}>¥ Japanese Yen (JPY)</option>
                            <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>$ US Dollar (USD)</option>
                            <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>€ Euro (EUR)</option>
                            <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>£ British Pound (GBP)</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                    </div>

                    <!-- Description (Optional) -->
                    <div>
                        <x-input-label for="description" :value="__('Description (Optional)')" />
                        <textarea id="description" name="description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                  placeholder="Additional notes about this account...">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <!-- Account Type Information -->
                    <div id="account-info" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4" style="display: none;">
                        <div class="flex items-start space-x-3">
                            <div id="account-icon" class="w-10 h-10 rounded-lg flex items-center justify-center"></div>
                            <div>
                                <h4 id="account-title" class="font-medium text-gray-900 dark:text-white"></h4>
                                <p id="account-description" class="text-sm text-gray-600 dark:text-gray-400 mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('accounts.index') }}" 
                           class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            Cancel
                        </a>
                        <x-primary-button>
                            {{ __('Create Account') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const accountInfo = document.getElementById('account-info');
            const accountIcon = document.getElementById('account-icon');
            const accountTitle = document.getElementById('account-title');
            const accountDescription = document.getElementById('account-description');

            const accountTypes = {
                checking: {
                    title: 'Checking Account',
                    description: 'Your everyday spending account for bills, groceries, and daily transactions. Usually offers easy access with debit cards and online banking.',
                    icon: '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>',
                    bgClass: 'bg-blue-500'
                },
                savings: {
                    title: 'Savings Account',
                    description: 'Money set aside for future goals, emergencies, or long-term savings. Usually earns interest and has limited monthly transactions.',
                    icon: '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                    bgClass: 'bg-green-500'
                },
                cash: {
                    title: 'Cash',
                    description: 'Physical money in your wallet, purse, or stored at home. Use this to track cash transactions and maintain accurate records.',
                    icon: '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>',
                    bgClass: 'bg-yellow-500'
                },
                credit: {
                    title: 'Credit Card',
                    description: 'Credit cards and lines of credit. The balance will be displayed as negative to represent debt. Track spending and payments accurately.',
                    icon: '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>',
                    bgClass: 'bg-red-500'
                }
            };

            typeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                
                if (selectedType && accountTypes[selectedType]) {
                    const type = accountTypes[selectedType];
                    
                    accountInfo.style.display = 'block';
                    accountIcon.className = `w-10 h-10 rounded-lg flex items-center justify-center ${type.bgClass}`;
                    accountIcon.innerHTML = type.icon;
                    accountTitle.textContent = type.title;
                    accountDescription.textContent = type.description;
                } else {
                    accountInfo.style.display = 'none';
                }
            });

            // Trigger change event if there's an old value
            if (typeSelect.value) {
                typeSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout> 