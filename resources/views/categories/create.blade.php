<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Budget Category') }}
            </h2>
            <a href="{{ route('budgets.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Back to Budget
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Category Details</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Create a new budget category to organize your spending</p>
                </div>
                
                <form method="POST" action="{{ route('categories.store') }}" class="p-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category Name *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="e.g., Food & Dining, Transportation, Entertainment" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color Picker -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category Color *
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="color" name="color" id="color" value="{{ old('color', '#0ea5e9') }}" 
                                       class="h-10 w-16 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" required>
                                <div class="flex space-x-2">
                                    <!-- Preset Colors -->
                                    <button type="button" class="w-8 h-8 rounded-full bg-blue-500 hover:scale-110 transition-transform duration-200" onclick="setColor('#0ea5e9')"></button>
                                    <button type="button" class="w-8 h-8 rounded-full bg-green-500 hover:scale-110 transition-transform duration-200" onclick="setColor('#22c55e')"></button>
                                    <button type="button" class="w-8 h-8 rounded-full bg-yellow-500 hover:scale-110 transition-transform duration-200" onclick="setColor('#f59e0b')"></button>
                                    <button type="button" class="w-8 h-8 rounded-full bg-red-500 hover:scale-110 transition-transform duration-200" onclick="setColor('#ef4444')"></button>
                                    <button type="button" class="w-8 h-8 rounded-full bg-purple-500 hover:scale-110 transition-transform duration-200" onclick="setColor('#8b5cf6')"></button>
                                    <button type="button" class="w-8 h-8 rounded-full bg-pink-500 hover:scale-110 transition-transform duration-200" onclick="setColor('#ec4899')"></button>
                                </div>
                            </div>
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Icon (Optional) -->
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Icon (Optional)
                            </label>
                            <select name="icon" id="icon" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Select an icon</option>
                                <option value="🏠" {{ old('icon') == '🏠' ? 'selected' : '' }}>🏠 Housing</option>
                                <option value="🍽️" {{ old('icon') == '🍽️' ? 'selected' : '' }}>🍽️ Food & Dining</option>
                                <option value="🚗" {{ old('icon') == '🚗' ? 'selected' : '' }}>🚗 Transportation</option>
                                <option value="🎮" {{ old('icon') == '🎮' ? 'selected' : '' }}>🎮 Entertainment</option>
                                <option value="🛒" {{ old('icon') == '🛒' ? 'selected' : '' }}>🛒 Shopping</option>
                                <option value="⚕️" {{ old('icon') == '⚕️' ? 'selected' : '' }}>⚕️ Healthcare</option>
                                <option value="📚" {{ old('icon') == '📚' ? 'selected' : '' }}>📚 Education</option>
                                <option value="✈️" {{ old('icon') == '✈️' ? 'selected' : '' }}>✈️ Travel</option>
                                <option value="💼" {{ old('icon') == '💼' ? 'selected' : '' }}>💼 Business</option>
                                <option value="💰" {{ old('icon') == '💰' ? 'selected' : '' }}>💰 Savings</option>
                                <option value="🎁" {{ old('icon') == '🎁' ? 'selected' : '' }}>🎁 Gifts</option>
                                <option value="📱" {{ old('icon') == '📱' ? 'selected' : '' }}>📱 Phone & Internet</option>
                            </select>
                            @error('icon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description (Optional)
                            </label>
                            <textarea name="description" id="description" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                      placeholder="Describe what this category is used for...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</h4>
                        <div class="flex items-center space-x-3 p-3 bg-white dark:bg-gray-800 rounded-lg border">
                            <div id="preview-color" class="w-4 h-4 rounded-full bg-blue-500"></div>
                            <div class="flex items-center space-x-2">
                                <span id="preview-icon">📊</span>
                                <span id="preview-name" class="font-medium text-gray-900 dark:text-white">Category Name</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('budgets.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md font-medium transition-colors duration-200">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>

            <!-- Popular Categories Suggestions -->
            <div class="mt-6 bg-gradient-to-r from-primary-50 to-success-50 dark:from-primary-900 dark:to-success-900 overflow-hidden shadow-lg rounded-xl border border-primary-200 dark:border-primary-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">💡 Popular Budget Categories</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div class="space-y-2">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">🏠 Housing</h4>
                            <ul class="text-gray-600 dark:text-gray-400 space-y-1">
                                <li>• Rent/Mortgage</li>
                                <li>• Utilities</li>
                                <li>• Home Maintenance</li>
                            </ul>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">🍽️ Food</h4>
                            <ul class="text-gray-600 dark:text-gray-400 space-y-1">
                                <li>• Groceries</li>
                                <li>• Restaurants</li>
                                <li>• Coffee & Snacks</li>
                            </ul>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">🚗 Transportation</h4>
                            <ul class="text-gray-600 dark:text-gray-400 space-y-1">
                                <li>• Gas</li>
                                <li>• Public Transit</li>
                                <li>• Car Maintenance</li>
                            </ul>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">💰 Savings</h4>
                            <ul class="text-gray-600 dark:text-gray-400 space-y-1">
                                <li>• Emergency Fund</li>
                                <li>• Retirement</li>
                                <li>• Vacation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function setColor(color) {
            document.getElementById('color').value = color;
            updatePreview();
        }

        function updatePreview() {
            const name = document.getElementById('name').value || 'Category Name';
            const color = document.getElementById('color').value;
            const icon = document.getElementById('icon').value || '📊';

            document.getElementById('preview-name').textContent = name;
            document.getElementById('preview-color').style.backgroundColor = color;
            document.getElementById('preview-icon').textContent = icon;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Update preview when inputs change
            document.getElementById('name').addEventListener('input', updatePreview);
            document.getElementById('color').addEventListener('input', updatePreview);
            document.getElementById('icon').addEventListener('change', updatePreview);

            // Initial preview update
            updatePreview();
        });
    </script>
    @endpush
</x-app-layout> 