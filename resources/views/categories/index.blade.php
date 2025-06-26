<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Add Category</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if($categories->count() > 0)
                <!-- Categories Overview -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Your Budget Categories</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $categories->count() }} {{ $categories->count() === 1 ? 'category' : 'categories' }}</span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-lg" style="background-color: {{ $category->color }}">
                                                {{ $category->icon ?? '📁' }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h4>
                                                @if($category->description)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $category->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('categories.edit', $category) }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Category Stats -->
                                    @php
                                        $currentBudget = $category->currentMonthBudget();
                                        $budgetAmount = $currentBudget ? $currentBudget->allocated_amount : 0;
                                        $spentAmount = $currentBudget ? $currentBudget->spent_amount : 0;
                                        $availableAmount = $budgetAmount - $spentAmount;
                                    @endphp
                                    
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">Budgeted</span>
                                            <span class="font-medium text-gray-900 dark:text-white">¥{{ number_format($budgetAmount, 0) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">Spent</span>
                                            <span class="font-medium {{ $spentAmount > 0 ? 'text-danger-600' : 'text-gray-900 dark:text-white' }}">¥{{ number_format($spentAmount, 0) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">Available</span>
                                            <span class="font-medium {{ $availableAmount >= 0 ? 'text-success-600' : 'text-danger-600' }}">¥{{ number_format($availableAmount, 0) }}</span>
                                        </div>
                                        
                                        @if($budgetAmount > 0)
                                            <div class="mt-3">
                                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                    <span>Progress</span>
                                                    <span>{{ $budgetAmount > 0 ? round(($spentAmount / $budgetAmount) * 100, 1) : 0 }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                    <div class="h-2 rounded-full {{ $spentAmount <= $budgetAmount ? 'bg-primary-600' : 'bg-danger-600' }}" 
                                                         style="width: {{ $budgetAmount > 0 ? min(100, ($spentAmount / $budgetAmount) * 100) : 0 }}%"></div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-3 text-center">
                                                <a href="{{ route('budgets.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                                                    Set Budget →
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-600">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">💡 Category Management Tips</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">Organize</h4>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">Create categories that match your spending habits and financial goals.</p>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">Budget</h4>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">Assign money to each category to practice zero-based budgeting.</p>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">Track</h4>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">Monitor your spending against each category to stay on track.</p>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="p-12 text-center">
                        <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No Categories Yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                            Create categories to organize your spending and start building your zero-based budget. Categories help you allocate every yen to a specific purpose.
                        </p>
                        <a href="{{ route('categories.create') }}" 
                           class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-block">
                            Create Your First Category
                        </a>
                    </div>
                </div>
                
                <!-- Category Suggestions -->
                <div class="bg-gradient-to-r from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 border border-primary-200 dark:border-primary-700 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">💡 Popular Category Ideas</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">🏠</span>
                            <span>Housing & Rent</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">🛒</span>
                            <span>Groceries</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">🚗</span>
                            <span>Transportation</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">⚡</span>
                            <span>Utilities</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">🎬</span>
                            <span>Entertainment</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">🍽️</span>
                            <span>Dining Out</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">💊</span>
                            <span>Healthcare</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <span class="text-lg">💰</span>
                            <span>Savings</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 