<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Recurring Transactions') }}
            </h2>
            <div class="flex space-x-3">
                <form method="POST" action="{{ route('recurring-transactions.process-due') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                        Process Due
                    </button>
                </form>
                <a href="{{ route('recurring-transactions.create') }}" class="bg-success-600 hover:bg-success-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Add Recurring Transaction
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Upcoming Transactions Alert -->
            @if($upcomingTransactions->count() > 0)
            <div class="bg-warning-50 border border-warning-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-warning-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-warning-800">
                            {{ $upcomingTransactions->count() }} recurring transaction{{ $upcomingTransactions->count() > 1 ? 's' : '' }} due in the next 7 days
                        </h3>
                        <div class="mt-2 text-sm text-warning-700">
                            @foreach($upcomingTransactions->take(3) as $upcoming)
                                <div class="flex justify-between items-center py-1">
                                    <span>{{ $upcoming->description }}</span>
                                    <span class="font-medium">{{ $upcoming->next_due_date->format('M j') }} - ¥{{ number_format(abs($upcoming->amount)) }}</span>
                                </div>
                            @endforeach
                            @if($upcomingTransactions->count() > 3)
                                <div class="text-xs mt-1">... and {{ $upcomingTransactions->count() - 3 }} more</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <form method="GET" action="{{ route('recurring-transactions.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search transactions..." 
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                            <select name="type" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">All Types</option>
                                <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                                <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Frequency</label>
                            <select name="frequency" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">All Frequencies</option>
                                <option value="daily" {{ request('frequency') === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ request('frequency') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ request('frequency') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ request('frequency') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Filter
                                </button>
                                <a href="{{ route('recurring-transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 inline-block">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recurring Transactions List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                @if($recurringTransactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Frequency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Next Due</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recurringTransactions as $recurring)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full flex items-center justify-center text-xs font-medium
                                                    {{ $recurring->type === 'income' ? 'bg-success-100 text-success-800' : 
                                                       ($recurring->type === 'expense' ? 'bg-danger-100 text-danger-800' : 'bg-primary-100 text-primary-800') }}">
                                                    {{ $recurring->type === 'income' ? '↓' : ($recurring->type === 'expense' ? '↑' : '↔') }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $recurring->description }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ ucfirst($recurring->type) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                        {{ $recurring->type === 'income' ? 'text-success-600' : 
                                           ($recurring->type === 'expense' ? 'text-danger-600' : 'text-primary-600') }}">
                                        {{ $recurring->type === 'income' ? '+' : ($recurring->type === 'expense' ? '-' : '') }}¥{{ number_format(abs($recurring->amount)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $recurring->account->color ?? '#6b7280' }}"></div>
                                            {{ $recurring->account->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($recurring->category)
                                            <div class="flex items-center">
                                                <span class="mr-2">{{ $recurring->category->icon ?? '📁' }}</span>
                                                {{ $recurring->category->name }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">No category</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($recurring->interval > 1)
                                            Every {{ $recurring->interval }} 
                                            @if($recurring->frequency === 'daily')
                                                days
                                            @elseif($recurring->frequency === 'weekly')
                                                weeks
                                            @elseif($recurring->frequency === 'monthly')
                                                months
                                            @else
                                                years
                                            @endif
                                        @else
                                            {{ ucfirst($recurring->frequency) }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <div class="flex flex-col">
                                            <span class="{{ $recurring->next_due_date <= now() ? 'text-danger-600 font-medium' : '' }}">
                                                {{ $recurring->next_due_date->format('M j, Y') }}
                                            </span>
                                            @if($recurring->next_due_date <= now())
                                                <span class="text-xs text-danger-500">Due now</span>
                                            @elseif($recurring->next_due_date <= now()->addDays(7))
                                                <span class="text-xs text-warning-500">Due soon</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $recurring->is_active ? 'bg-success-100 text-success-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ $recurring->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('recurring-transactions.show', $recurring) }}" class="text-primary-600 hover:text-primary-900">View</a>
                                            <a href="{{ route('recurring-transactions.edit', $recurring) }}" class="text-warning-600 hover:text-warning-900">Edit</a>
                                            
                                            <form method="POST" action="{{ route('recurring-transactions.toggle', $recurring) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-{{ $recurring->is_active ? 'gray' : 'success' }}-600 hover:text-{{ $recurring->is_active ? 'gray' : 'success' }}-900">
                                                    {{ $recurring->is_active ? 'Pause' : 'Resume' }}
                                                </button>
                                            </form>
                                            
                                            <form method="POST" action="{{ route('recurring-transactions.destroy', $recurring) }}" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this recurring transaction?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger-600 hover:text-danger-900">Delete</button>
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
                        {{ $recurringTransactions->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No recurring transactions found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first recurring transaction.</p>
                        <a href="{{ route('recurring-transactions.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                            Add Recurring Transaction
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 