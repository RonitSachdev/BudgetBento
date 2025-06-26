<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
            @if(isset($setupComplete) && $setupComplete)
            <div class="flex space-x-3">
                <a href="{{ route('transactions.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add Transaction</span>
                </a>
                <a href="{{ route('budgets.index') }}" class="bg-success-600 hover:bg-success-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Manage Budget</span>
                </a>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(!isset($setupComplete) || !$setupComplete)
                <!-- Setup Checklist -->
                <div class="bg-gradient-to-r from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 border border-primary-200 dark:border-primary-700 rounded-xl p-8">
                    <div class="text-center mb-8">
                        <div class="mx-auto w-20 h-20 bg-primary-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Welcome to BudgetBento! 🍱</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                            Let's get you started with zero-based budgeting. Complete these essential steps to begin managing your finances like a pro.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                        <!-- Step 1: Add Accounts -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 relative">
                            @if(isset($hasAccounts) && $hasAccounts)
                                <div class="absolute -top-3 -right-3 w-8 h-8 bg-success-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">1</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add Your Accounts</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if(isset($hasAccounts) && $hasAccounts)
                                            ✅ Accounts added successfully!
                                        @else
                                            Connect your bank accounts, credit cards, and cash
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-300 mb-6">
                                Add your checking accounts, savings, credit cards, and cash to get a complete picture of your finances. This is the foundation of your budget.
                            </p>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                    </svg>
                                    <span>🏦 Checking & Savings accounts</span>
                                </div>
                                <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                    </svg>
                                    <span>💳 Credit cards & loans</span>
                                </div>
                                <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                    </svg>
                                    <span>💵 Cash & other assets</span>
                                </div>
                            </div>
                            
                            @if(isset($hasAccounts) && $hasAccounts)
                                <a href="{{ route('accounts.index') }}" class="w-full bg-success-600 hover:bg-success-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>View Accounts</span>
                                </a>
                            @else
                                <a href="{{ route('accounts.create') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span>Add Your First Account</span>
                                </a>
                            @endif
                        </div>

                        <!-- Step 2: Create Categories -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 relative">
                            @if(isset($hasCategories) && $hasCategories)
                                <div class="absolute -top-3 -right-3 w-8 h-8 bg-success-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Create Categories</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if(isset($hasCategories) && $hasCategories)
                                            ✅ Categories created successfully!
                                        @else
                                            Organize your spending into categories
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-300 mb-6">
                                Create categories for your expenses like groceries, rent, entertainment, etc. This helps you allocate money to specific purposes in your budget.
                            </p>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                    </svg>
                                    <span>🏠 Housing & utilities</span>
                                </div>
                                <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                    </svg>
                                    <span>🛒 Groceries & food</span>
                                </div>
                                <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                    </svg>
                                    <span>🎬 Entertainment & hobbies</span>
                                </div>
                            </div>
                            
                            @if(isset($hasCategories) && $hasCategories)
                                <a href="{{ route('categories.index') }}" class="w-full bg-success-600 hover:bg-success-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>View Categories</span>
                                </a>
                            @else
                                <a href="{{ route('categories.create') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span>Create Your First Category</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    @if(isset($hasAccounts) && isset($hasCategories) && $hasAccounts && $hasCategories)
                        <!-- Setup Complete Message -->
                        <div class="text-center mt-8 p-6 bg-success-50 dark:bg-success-900 border border-success-200 dark:border-success-700 rounded-xl">
                            <div class="mx-auto w-16 h-16 bg-success-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-success-800 dark:text-success-200 mb-2">Great job! 🎉</h3>
                            <p class="text-success-700 dark:text-success-300 mb-4">
                                You've completed the essential setup. Now you can start creating budgets and tracking transactions!
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="{{ route('budgets.index') }}" class="bg-success-600 hover:bg-success-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                    Create Your First Budget
                                </a>
                                <a href="{{ route('transactions.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                    Add Transaction
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Next Steps -->
                        <div class="text-center mt-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">What's Next?</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Once you complete both steps above, you'll be able to:
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span>Create monthly budgets</span>
                                </div>
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <span>Track transactions</span>
                                </div>
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span>Monitor spending</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <!-- Normal Dashboard Content -->
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Net Worth -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Net Worth</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">¥{{ number_format($totalNetWorth ?? 0, 0) }}</p>
                            </div>
                            <div class="bg-primary-100 dark:bg-primary-900 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Budgeted -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Budgeted This Month</p>
                                <p class="text-2xl font-bold text-success-600 dark:text-success-400">¥{{ number_format($totalBudgeted ?? 0, 0) }}</p>
                            </div>
                            <div class="bg-success-100 dark:bg-success-900 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Spent -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Spent This Month</p>
                                <p class="text-2xl font-bold text-danger-600 dark:text-danger-400">¥{{ number_format($totalSpent ?? 0, 0) }}</p>
                            </div>
                            <div class="bg-danger-100 dark:bg-danger-900 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-danger-600 dark:text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Available to Budget -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available</p>
                                <p class="text-2xl font-bold {{ ($totalAvailable ?? 0) >= 0 ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400' }}">
                                    ¥{{ number_format($totalAvailable ?? 0, 0) }}
                                </p>
                            </div>
                            <div class="bg-warning-100 dark:bg-warning-900 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Budget Overview Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Budget Overview</h3>
                            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Current Month</span>
                            </div>
                        </div>
                        <div class="relative h-64">
                            <canvas id="budgetOverviewChart"></canvas>
                        </div>
                    </div>

                    <!-- Spending Trends Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Spending Trends</h3>
                            <div class="flex items-center space-x-3">
                                <!-- Period Selector -->
                                <select id="periodSelector" onchange="changePeriod()" class="text-xs border border-gray-300 dark:border-gray-600 rounded-md px-3 py-1 pr-12 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 w-[280px]">
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                                
                                <!-- Range Type Selector -->
                                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                                    <button onclick="changeSpendingRange('week')" id="range-week" class="px-3 py-1 text-xs font-medium rounded-md transition-all duration-200 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                        Week
                                    </button>
                                    <button onclick="changeSpendingRange('month')" id="range-month" class="px-3 py-1 text-xs font-medium rounded-md transition-all duration-200 bg-primary-600 text-white">
                                        Month
                                    </button>
                                    <button onclick="changeSpendingRange('year')" id="range-year" class="px-3 py-1 text-xs font-medium rounded-md transition-all duration-200 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                        Year
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative h-64">
                            <canvas id="spendingTrendsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Budget Categories and Recent Transactions -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Budget Categories -->
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Budget Categories</h3>
                                <a href="{{ route('budgets.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if(($budgets ?? collect())->count() > 0)
                                <div class="space-y-4">
                                    @foreach($budgets as $budget)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $budget->category->color }}"></div>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $budget->category->name }}</h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        ¥{{ number_format($budget->spent_amount, 0) }} of ¥{{ number_format($budget->allocated_amount, 0) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium {{ $budget->available_amount >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                                                    ¥{{ number_format($budget->available_amount, 0) }}
                                                </p>
                                                <div class="w-24 bg-gray-200 rounded-full h-2 mt-1">
                                                    <div class="bg-primary-600 h-2 rounded-full" style="width: {{ min(100, ($budget->spent_amount / max(1, $budget->allocated_amount)) * 100) }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Budget Set</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Start your zero-based budgeting journey by creating categories and allocating money.</p>
                                    <a href="{{ route('budgets.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                        Create Budget
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                                <a href="{{ route('transactions.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if(($recentTransactions ?? collect())->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentTransactions->take(8) as $transaction)
                                        <div class="flex items-center justify-between py-2">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 {{ $transaction->transaction_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $transaction->payee }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('M d') }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium text-sm {{ $transaction->amount >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                                                    {{ $transaction->formatted_amount }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">No transactions yet</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Accounts Overview -->
                @if(($accounts ?? collect())->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Accounts</h3>
                            <a href="{{ route('accounts.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">Manage Accounts</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($accounts as $account)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $account->name }}</h4>
                                        <span class="text-xs px-2 py-1 bg-primary-100 text-primary-800 rounded-full">{{ ucfirst($account->type) }}</span>
                                    </div>
                                    <p class="text-xl font-bold {{ $account->balance >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                                        {{ $account->formatted_balance }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
                @endif
            @endif
        </div>
    </div>

    @if(isset($setupComplete) && $setupComplete)
    @push('scripts')
    <script>
        let spendingChart = null;
        let currentRange = 'month';
        let availablePeriods = {};
        let currentPeriod = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Load chart data and update charts
            fetch('{{ route("api.budget-data") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.labels.length > 0) {
                        updateBudgetChart('budgetOverviewChart', data.labels, data.data);
                    }
                })
                .catch(error => console.error('Error loading budget data:', error));

            // Load initial spending trends (default: month)
            changeSpendingRange('month');
        });

        function loadAvailablePeriods(range) {
            fetch(`{{ route("api.available-periods") }}?range=${range}`)
                .then(response => response.json())
                .then(data => {
                    availablePeriods[range] = data.periods;
                    populatePeriodSelector(range);
                    
                    // Set default period (current or latest available)
                    currentPeriod = data.current || data.periods[0]?.value;
                    document.getElementById('periodSelector').value = currentPeriod;
                    
                    loadSpendingTrends(range, currentPeriod);
                })
                .catch(error => console.error('Error loading periods:', error));
        }

        function populatePeriodSelector(range) {
            const selector = document.getElementById('periodSelector');
            selector.innerHTML = '';
            
            if (availablePeriods[range]) {
                availablePeriods[range].forEach(period => {
                    const option = document.createElement('option');
                    option.value = period.value;
                    option.textContent = period.label;
                    selector.appendChild(option);
                });
            }
        }

        function loadSpendingTrends(range, period) {
            fetch(`{{ route("api.spending-trends") }}?range=${range}&period=${period}`)
                .then(response => response.json())
                .then(data => {
                    if (data.labels.length > 0) {
                        updateSpendingChart('spendingTrendsChart', data.labels, data.data, range, data.title);
                    }
                })
                .catch(error => console.error('Error loading spending trends:', error));
        }

        function changeSpendingRange(range) {
            // Update button states
            document.querySelectorAll('[id^="range-"]').forEach(btn => {
                btn.className = 'px-3 py-1 text-xs font-medium rounded-md transition-all duration-200 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white';
            });
            document.getElementById(`range-${range}`).className = 'px-3 py-1 text-xs font-medium rounded-md transition-all duration-200 bg-primary-600 text-white';
            
            currentRange = range;
            
            // Load available periods for this range
            if (availablePeriods[range]) {
                populatePeriodSelector(range);
                currentPeriod = document.getElementById('periodSelector').value;
                loadSpendingTrends(range, currentPeriod);
            } else {
                loadAvailablePeriods(range);
            }
        }

        function changePeriod() {
            currentPeriod = document.getElementById('periodSelector').value;
            loadSpendingTrends(currentRange, currentPeriod);
        }
    </script>
    @endpush
    @endif
</x-app-layout>
