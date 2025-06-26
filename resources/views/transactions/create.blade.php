<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add Transaction') }}
            </h2>
            <a href="{{ route('transactions.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Back to Transactions
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transaction Details</h3>
                </div>
                
                <form method="POST" action="{{ route('transactions.store') }}" class="p-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Transaction Type -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Transaction Type *
                            </label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="income" class="text-success-600 focus:ring-success-500" required>
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Income</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="expense" class="text-danger-600 focus:ring-danger-500" required>
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Expense</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="transfer" class="text-primary-600 focus:ring-primary-500" required>
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Transfer</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payee -->
                        <div>
                            <label for="payee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payee *
                            </label>
                            <input type="text" name="payee" id="payee" value="{{ old('payee') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Who did you pay or who paid you?" required>
                            @error('payee')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Amount (¥) *
                            </label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" 
                                   step="1" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="0" required>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account -->
                        <div>
                            <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Account *
                            </label>
                            <select name="account_id" id="account_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="">Select an account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }} ({{ $account->formatted_balance }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category
                            </label>
                            <select name="category_id" id="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transaction Date -->
                        <div>
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Transaction Date *
                            </label>
                            <input type="date" name="transaction_date" id="transaction_date" 
                                   value="{{ old('transaction_date', date('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            @error('transaction_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Memo -->
                        <div class="md:col-span-2">
                            <label for="memo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Memo / Notes
                            </label>
                            <textarea name="memo" id="memo" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                      placeholder="Additional details about this transaction">{{ old('memo') }}</textarea>
                            @error('memo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('transactions.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md font-medium transition-colors duration-200">
                            Add Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-hide category selection for transfers
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const categoryDiv = document.getElementById('category_id').closest('div');
            
            typeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'transfer') {
                        categoryDiv.style.display = 'none';
                        document.getElementById('category_id').value = '';
                    } else {
                        categoryDiv.style.display = 'block';
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 