<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transactions') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Add Transaction</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search transactions..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        
                        <!-- Account Filter -->
                        <div>
                            <select name="account" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">All Accounts</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ request('account') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type Filter & Submit -->
                        <div class="flex space-x-2">
                            <select name="type" class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">All Types</option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md font-medium transition-colors duration-200">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                @if($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Payee
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Account
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($transactions as $transaction)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $transaction->transaction_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $transaction->payee }}
                                                </div>
                                                @if($transaction->memo)
                                                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                                        {{ $transaction->memo }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->category)
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $transaction->category->color }}"></div>
                                                    <span class="text-sm text-gray-900 dark:text-white">{{ $transaction->category->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Uncategorized</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $transaction->account->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium {{ $transaction->amount >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                                            {{ $transaction->formatted_amount }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('transactions.edit', $transaction) }}" 
                                                   class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" 
                                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger-600 hover:text-danger-900 dark:text-danger-400 dark:hover:text-danger-300">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $transactions->withQueryString()->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="p-12 text-center">
                        <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No Transactions Found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                            Start tracking your finances by adding your first transaction.
                        </p>
                        <a href="{{ route('transactions.create') }}" 
                           class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-block">
                            Add Your First Transaction
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 