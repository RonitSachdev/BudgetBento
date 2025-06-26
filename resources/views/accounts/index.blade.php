<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Accounts') }}
            </h2>
            <a href="{{ route('accounts.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Add Account</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Net Worth Summary -->
            <div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 overflow-hidden shadow-xl rounded-xl text-white relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-white bg-opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 20px 20px;"></div>
                </div>
                
                <div class="relative p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-white opacity-90">Total Net Worth</h3>
                                    <p class="text-xs text-white opacity-70">All accounts combined</p>
                                </div>
                            </div>
                            <p class="text-4xl font-bold text-white mb-2">
                                ¥{{ number_format($accounts->sum('balance'), 0) }}
                            </p>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-success-400 rounded-full animate-pulse"></div>
                                <span class="text-sm text-white opacity-80">{{ $accounts->count() }} {{ $accounts->count() === 1 ? 'Account' : 'Accounts' }} Active</span>
                            </div>
                        </div>
                        
                        <div class="hidden md:block">
                            <div class="w-20 h-20 bg-white bg-opacity-10 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-10 h-10 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Type Breakdown -->
                    <div class="border-t border-white border-opacity-20 pt-6">
                        <h4 class="text-sm font-medium text-white opacity-90 mb-4">Account Breakdown</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-6 h-6 bg-blue-400 rounded-md flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-white opacity-80">Checking</span>
                                </div>
                                <p class="text-lg font-bold text-white">¥{{ number_format($accounts->where('type', 'checking')->sum('balance'), 0) }}</p>
                                <p class="text-xs text-white opacity-60">{{ $accounts->where('type', 'checking')->count() }} accounts</p>
                            </div>
                            
                            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-6 h-6 bg-green-400 rounded-md flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-white opacity-80">Savings</span>
                                </div>
                                <p class="text-lg font-bold text-white">¥{{ number_format($accounts->where('type', 'savings')->sum('balance'), 0) }}</p>
                                <p class="text-xs text-white opacity-60">{{ $accounts->where('type', 'savings')->count() }} accounts</p>
                            </div>
                            
                            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-6 h-6 bg-yellow-400 rounded-md flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-white opacity-80">Cash</span>
                                </div>
                                <p class="text-lg font-bold text-white">¥{{ number_format($accounts->where('type', 'cash')->sum('balance'), 0) }}</p>
                                <p class="text-xs text-white opacity-60">{{ $accounts->where('type', 'cash')->count() }} accounts</p>
                            </div>
                            
                            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-6 h-6 bg-red-400 rounded-md flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-white opacity-80">Credit</span>
                                </div>
                                <p class="text-lg font-bold text-white">¥{{ number_format($accounts->where('type', 'credit')->sum('balance'), 0) }}</p>
                                <p class="text-xs text-white opacity-60">{{ $accounts->where('type', 'credit')->count() }} accounts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($accounts->count() > 0)
                <!-- Accounts Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($accounts as $account)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-200">
                            <div class="p-6">
                                <!-- Account Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-br {{ $account->type === 'checking' ? 'from-blue-500 to-blue-600' : ($account->type === 'savings' ? 'from-green-500 to-green-600' : ($account->type === 'cash' ? 'from-yellow-500 to-yellow-600' : 'from-red-500 to-red-600')) }} rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($account->type === 'checking')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                @elseif($account->type === 'savings')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                @elseif($account->type === 'cash')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $account->name }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">{{ $account->type }} Account</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('accounts.edit', $account) }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                <!-- Balance -->
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Current Balance</p>
                                    <p class="text-2xl font-bold {{ $account->balance >= 0 ? 'text-gray-900 dark:text-white' : 'text-danger-600' }}">
                                        {{ $account->formatted_balance }}
                                    </p>
                                </div>

                                <!-- Account Details -->
                                @if($account->description)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $account->description }}</p>
                                    </div>
                                @endif

                                <!-- Account Stats -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Initial Balance</span>
                                        <span class="text-gray-900 dark:text-white font-medium">¥{{ number_format($account->initial_balance, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm mt-1">
                                        <span class="text-gray-500 dark:text-gray-400">Currency</span>
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $account->currency }}</span>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="mt-4 flex space-x-2">
                                    <a href="{{ route('transactions.create', ['account' => $account->id]) }}" 
                                       class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-center py-2 px-3 rounded-md text-sm font-medium transition-colors duration-200">
                                        Add Transaction
                                    </a>
                                    <a href="{{ route('transactions.index', ['account' => $account->id]) }}" 
                                       class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-center py-2 px-3 rounded-md text-sm font-medium transition-colors duration-200">
                                        View History
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="p-12 text-center">
                        <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No Accounts Yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                            Start by adding your bank accounts, credit cards, and cash to track your complete financial picture.
                        </p>
                        <a href="{{ route('accounts.create') }}" 
                           class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-block">
                            Add Your First Account
                        </a>
                    </div>
                </div>
            @endif

            <!-- Account Types Info -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-600">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">💡 Account Types Explained</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900 dark:text-white">Checking</h4>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Everyday spending account for bills and daily transactions.</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900 dark:text-white">Savings</h4>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Money set aside for future goals and emergencies.</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900 dark:text-white">Cash</h4>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Physical money in your wallet or cash reserves.</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900 dark:text-white">Credit</h4>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Credit cards and lines of credit. Balances shown as negative.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 