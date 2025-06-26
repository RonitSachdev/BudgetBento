<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('accounts.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Account') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                <form method="POST" action="{{ route('accounts.update', $account) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Account Name -->
                    <div>
                        <x-input-label for="name" :value="__('Account Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                      :value="old('name', $account->name)" required autofocus autocomplete="name" 
                                      placeholder="e.g., Main Checking, Emergency Savings" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose a descriptive name to easily identify this account.</p>
                    </div>

                    <!-- Account Type -->
                    <div>
                        <x-input-label for="type" :value="__('Account Type')" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="">Select account type</option>
                            <option value="checking" {{ old('type', $account->type) == 'checking' ? 'selected' : '' }}>
                                🏦 Checking Account
                            </option>
                            <option value="savings" {{ old('type', $account->type) == 'savings' ? 'selected' : '' }}>
                                💰 Savings Account
                            </option>
                            <option value="cash" {{ old('type', $account->type) == 'cash' ? 'selected' : '' }}>
                                💵 Cash
                            </option>
                            <option value="credit" {{ old('type', $account->type) == 'credit' ? 'selected' : '' }}>
                                💳 Credit Card
                            </option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <!-- Current Balance (Read-only) -->
                    <div>
                        <x-input-label for="current_balance" :value="__('Current Balance')" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">¥</span>
                            </div>
                            <input type="text" id="current_balance" 
                                   class="block w-full pl-7 pr-12 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm bg-gray-50 dark:bg-gray-800" 
                                   value="{{ number_format($account->balance, 2) }}" readonly />
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Current balance is updated automatically through transactions. To adjust, add a transaction.</p>
                    </div>

                    <!-- Description (Optional) -->
                    <div>
                        <x-input-label for="description" :value="__('Description (Optional)')" />
                        <textarea id="description" name="description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                  placeholder="Additional notes about this account...">{{ old('description', $account->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <!-- Account Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-3">Account Information</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Initial Balance:</span>
                                <span class="font-medium text-gray-900 dark:text-white ml-2">¥{{ number_format($account->initial_balance, 2) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Currency:</span>
                                <span class="font-medium text-gray-900 dark:text-white ml-2">{{ $account->currency }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Created:</span>
                                <span class="font-medium text-gray-900 dark:text-white ml-2">{{ $account->created_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="font-medium {{ $account->is_active ? 'text-success-600' : 'text-danger-600' }} ml-2">
                                    {{ $account->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex space-x-4">
                            <a href="{{ route('accounts.index') }}" 
                               class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Account') }}
                            </x-primary-button>
                        </div>
                        
                        @if($account->is_active)
                            <form method="POST" action="{{ route('accounts.destroy', $account) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-danger-600 hover:bg-danger-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                        onclick="return confirm('Are you sure you want to deactivate this account? This will hide it from your dashboard but preserve transaction history.')">
                                    Deactivate Account
                                </button>
                            </form>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 