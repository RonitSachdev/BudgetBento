<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BudgetBento - Simple Zero-Based Budgeting</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-600 to-primary-700 rounded-lg flex items-center justify-center">
                            <span class="text-white text-lg font-bold">🍱</span>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">
                            BudgetBento
                        </span>
                    </div>
                    
                    <!-- Auth Links -->
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                                    Sign In
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-gray-50 to-white py-20 sm:py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Hero Content -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Simple
                        <span class="bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">
                            Zero-Based
                        </span>
                        <br>Budgeting
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                        Take control of your finances with BudgetBento. Assign every yen a purpose, 
                        track your spending, and achieve your financial goals with our clean, intuitive interface.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                        <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Start Budgeting Free
                        </a>
                        <a href="#features" class="text-gray-600 hover:text-gray-900 px-8 py-3 text-lg font-medium transition-colors">
                            Learn More
                        </a>
                    </div>
                    
                    <!-- Hero Image/Demo -->
                    <div class="relative max-w-4xl mx-auto">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                    <div class="ml-4 text-sm text-gray-500">BudgetBento Dashboard</div>
                                </div>
                            </div>
                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Sample Cards -->
                                    <div class="bg-gradient-to-br from-success-50 to-success-100 p-6 rounded-xl border border-success-200">
                                        <h3 class="font-semibold text-success-800 mb-2">Total Income</h3>
                                        <p class="text-2xl font-bold text-success-900">¥450,000</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 p-6 rounded-xl border border-primary-200">
                                        <h3 class="font-semibold text-primary-800 mb-2">Budgeted</h3>
                                        <p class="text-2xl font-bold text-primary-900">¥420,000</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-warning-50 to-warning-100 p-6 rounded-xl border border-warning-200">
                                        <h3 class="font-semibold text-warning-800 mb-2">Available</h3>
                                        <p class="text-2xl font-bold text-warning-900">¥30,000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                        Everything you need to budget better
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Simple tools that make managing your money feel effortless
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Zero-Based Budgeting</h3>
                        <p class="text-gray-600">Assign every yen a purpose. Make sure your income minus expenses equals zero.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-success-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Recurring Transactions</h3>
                        <p class="text-gray-600">Set up automatic recurring income and expenses. Never forget a bill again.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-warning-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Visual Analytics</h3>
                        <p class="text-gray-600">Beautiful charts and graphs help you understand your spending patterns.</p>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-danger-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Multiple Accounts</h3>
                        <p class="text-gray-600">Track checking, savings, cash, and credit accounts all in one place.</p>
                    </div>
                    
                    <!-- Feature 5 -->
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Categories</h3>
                        <p class="text-gray-600">Organize your spending with customizable categories and colorful icons.</p>
                    </div>
                    
                    <!-- Feature 6 -->
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Mobile Friendly</h3>
                        <p class="text-gray-600">Access your budget anywhere with our responsive, mobile-optimized design.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-br from-primary-600 to-primary-700 py-20">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                    Ready to take control of your finances?
                </h2>
                <p class="text-xl text-primary-100 mb-8">
                    Join thousands of users who have already transformed their financial lives with BudgetBento.
                </p>
                <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-gray-50 px-8 py-3 rounded-lg text-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                    Start Your Free Budget Today
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-600 to-primary-700 rounded-lg flex items-center justify-center">
                            <span class="text-white text-lg font-bold">🍱</span>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">
                            BudgetBento
                        </span>
                    </div>
                    <div class="text-gray-600 text-sm">
                        © {{ date('Y') }} BudgetBento. Made with ❤️ for better budgeting.
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
