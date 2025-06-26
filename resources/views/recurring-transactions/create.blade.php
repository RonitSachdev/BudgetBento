<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add Recurring Transaction') }}
            </h2>
            <a href="{{ route('recurring-transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                <form method="POST" action="{{ route('recurring-transactions.store') }}" class="p-6 space-y-6">
                    @csrf

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description <span class="text-danger-500">*</span>
                            </label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}" required
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="e.g., Monthly Rent, Weekly Groceries">
                            @error('description')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Amount (¥) <span class="text-danger-500">*</span>
                            </label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01" min="0.01" required
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="0.00">
                            @error('amount')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Transaction Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Transaction Type <span class="text-danger-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="relative">
                                <input type="radio" name="type" value="income" {{ old('type') === 'income' ? 'checked' : '' }} class="sr-only peer" required>
                                <div class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 cursor-pointer transition-all duration-200 peer-checked:border-success-500 peer-checked:bg-success-50 dark:peer-checked:bg-success-900/20 hover:border-success-300">
                                    <div class="flex items-center justify-center mb-2">
                                        <div class="w-8 h-8 rounded-full bg-success-100 dark:bg-success-900 flex items-center justify-center">
                                            <span class="text-success-600 dark:text-success-400">↓</span>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">Income</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Money coming in</div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="type" value="expense" {{ old('type') === 'expense' ? 'checked' : '' }} class="sr-only peer" required>
                                <div class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 cursor-pointer transition-all duration-200 peer-checked:border-danger-500 peer-checked:bg-danger-50 dark:peer-checked:bg-danger-900/20 hover:border-danger-300">
                                    <div class="flex items-center justify-center mb-2">
                                        <div class="w-8 h-8 rounded-full bg-danger-100 dark:bg-danger-900 flex items-center justify-center">
                                            <span class="text-danger-600 dark:text-danger-400">↑</span>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">Expense</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Money going out</div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="type" value="transfer" {{ old('type') === 'transfer' ? 'checked' : '' }} class="sr-only peer" required>
                                <div class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 cursor-pointer transition-all duration-200 peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300">
                                    <div class="flex items-center justify-center mb-2">
                                        <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                            <span class="text-primary-600 dark:text-primary-400">↔</span>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">Transfer</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Between accounts</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account and Category -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Account <span class="text-danger-500">*</span>
                            </label>
                            <select name="account_id" id="account_id" required
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select an account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }} (¥{{ number_format($account->balance) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category
                            </label>
                            <select name="category_id" id="category_id"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select a category (optional)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->icon }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Frequency Settings -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Frequency Settings</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Frequency <span class="text-danger-500">*</span>
                                </label>
                                <select name="frequency" id="frequency" required
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select frequency</option>
                                    <option value="daily" {{ old('frequency') === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('frequency') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('frequency') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ old('frequency') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('frequency')
                                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="interval" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Every (Interval) <span class="text-danger-500">*</span>
                                </label>
                                <input type="number" name="interval" id="interval" value="{{ old('interval', 1) }}" min="1" max="365" required
                                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="1">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">e.g., 2 for "every 2 weeks"</p>
                                @error('interval')
                                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Date Settings -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Date Settings</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Start Date <span class="text-danger-500">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', now()->toDateString()) }}" required
                                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    End Date (Optional)
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty for no end date</p>
                                @error('end_date')
                                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Limits -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Limits (Optional)</h3>
                        
                        <div>
                            <label for="max_occurrences" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Maximum Number of Occurrences
                            </label>
                            <input type="number" name="max_occurrences" id="max_occurrences" value="{{ old('max_occurrences') }}" min="1" max="1000"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="e.g., 12 for 12 months">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty for unlimited occurrences</p>
                            @error('max_occurrences')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('recurring-transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-success-600 hover:bg-success-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            Create Recurring Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 