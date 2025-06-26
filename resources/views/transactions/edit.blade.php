<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Transaction') }}
            </h2>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to Transactions
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Transaction Type -->
                        <div>
                            <x-input-label for="type" :value="__('Transaction Type')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Type</option>
                                <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                                <option value="transfer" {{ old('type', $transaction->type) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Account -->
                        <div>
                            <x-input-label for="account_id" :value="__('Account')" />
                            <select id="account_id" name="account_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id', $transaction->account_id) == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }} (¥{{ number_format($account->balance, 0) }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Category (Optional)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->icon }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Payee -->
                        <div>
                            <x-input-label for="payee" :value="__('Payee/Description')" />
                            <x-text-input id="payee" name="payee" type="text" class="mt-1 block w-full" :value="old('payee', $transaction->payee)" required />
                            <x-input-error :messages="$errors->get('payee')" class="mt-2" />
                        </div>

                        <!-- Amount -->
                        <div>
                            <x-input-label for="amount" :value="__('Amount (¥)')" />
                            <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('amount', abs($transaction->amount))" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">Enter the amount as a positive number. The sign will be determined by the transaction type.</p>
                        </div>

                        <!-- Transaction Date -->
                        <div>
                            <x-input-label for="transaction_date" :value="__('Transaction Date')" />
                            <x-text-input id="transaction_date" name="transaction_date" type="date" class="mt-1 block w-full" :value="old('transaction_date', $transaction->transaction_date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>

                        <!-- Memo -->
                        <div>
                            <x-input-label for="memo" :value="__('Memo (Optional)')" />
                            <textarea id="memo" name="memo" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('memo', $transaction->memo) }}</textarea>
                            <x-input-error :messages="$errors->get('memo')" class="mt-2" />
                        </div>

                        

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transaction Information Panel -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Current Transaction Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Type:</span>
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : ($transaction->type === 'expense' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Account:</span>
                                <span class="ml-2 text-sm text-gray-900">{{ $transaction->account->name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Category:</span>
                                <span class="ml-2 text-sm text-gray-900">
                                    @if($transaction->category)
                                        {{ $transaction->category->icon }} {{ $transaction->category->name }}
                                    @else
                                        <span class="text-gray-400">None</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Amount:</span>
                                <span class="ml-2 text-sm font-semibold {{ $transaction->amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->formatted_amount }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Date:</span>
                                <span class="ml-2 text-sm text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</span>
                            </div>
                            
                        </div>
                    </div>
                    @if($transaction->memo)
                        <div class="mt-4">
                            <span class="text-sm font-medium text-gray-500">Memo:</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $transaction->memo }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Delete Transaction -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-sm text-gray-600 mb-4">Once you delete this transaction, it cannot be recovered. This will also update your account balance and budget allocations.</p>
                    <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            Delete Transaction
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 