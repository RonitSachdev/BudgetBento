<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Budget Management') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('categories.create') }}" class="bg-success-600 hover:bg-success-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add Category</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Current Month Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ now()->format('F Y') }} Budget
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Budgeted</p>
                                <p class="text-lg font-bold text-success-600">¥{{ number_format($totalAllocated ?? 0, 0) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Spent</p>
                                <p class="text-lg font-bold text-danger-600">¥{{ number_format($totalSpent ?? 0, 0) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Available</p>
                                <p class="text-lg font-bold {{ ($totalAvailable ?? 0) >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                                    ¥{{ number_format($totalAvailable ?? 0, 0) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget Categories -->
            @if(($categories ?? collect())->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Budget Categories</h3>
                    </div>
                    <div class="p-6">
                        <form id="budgetForm" action="{{ route('budgets.allocate') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                @foreach($categories as $category)
                                    @php
                                        $budget = $budgets->get($category->id);
                                        $allocated = $budget ? $budget->allocated_amount : 0;
                                        $spent = $budget ? $budget->spent_amount : 0;
                                        $available = $allocated - $spent;
                                    @endphp
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center space-x-4 flex-1">
                                            <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }}"></div>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $category->name }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    Spent: ¥{{ number_format($spent, 0) }} | Available: 
                                                    <span class="{{ $available >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                                                        ¥{{ number_format($available, 0) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">¥</span>
                                                <input 
                                                    type="number" 
                                                    name="allocations[{{ $loop->index }}][amount]" 
                                                    value="{{ $allocated }}"
                                                    min="0"
                                                    step="100"
                                                    class="w-24 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                                    placeholder="0"
                                                >
                                                <input 
                                                    type="hidden" 
                                                    name="allocations[{{ $loop->index }}][category_id]" 
                                                    value="{{ $category->id }}"
                                                >
                                            </div>
                                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                                <div 
                                                    class="bg-primary-600 h-2 rounded-full transition-all duration-300" 
                                                    style="width: {{ $allocated > 0 ? min(100, ($spent / $allocated) * 100) : 0 }}%"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <button 
                                    type="submit" 
                                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200"
                                >
                                    Update Budget Allocations
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <!-- No Categories State -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="p-12 text-center">
                        <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Start Your Zero-Based Budget</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                            Create budget categories to start allocating every yen. Zero-based budgeting means giving every yen a job before you spend it.
                        </p>
                        <div class="space-y-4">
                            <a href="{{ route('categories.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-block">
                                Create Your First Category
                            </a>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <p>Popular categories: Housing, Food, Transportation, Entertainment</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Zero-Based Budgeting Tips -->
            <div class="bg-gradient-to-r from-primary-50 to-success-50 dark:from-primary-900 dark:to-success-900 overflow-hidden shadow-lg rounded-xl border border-primary-200 dark:border-primary-700">
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-primary-100 dark:bg-primary-800 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Zero-Based Budgeting Tips</h3>
                            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                <li>• Allocate every yen of income to a category</li>
                                <li>• Income minus expenses should equal zero</li>
                                <li>• Move money between categories as needed</li>
                                <li>• Track every transaction and assign to categories</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-calculate totals when allocations change
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('budgetForm');
            const inputs = form.querySelectorAll('input[type="number"]');
            
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Could add real-time calculation updates here
                    console.log('Budget allocation changed');
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 