<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BudgetBento') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <!-- Chart.js Functions -->
        <script>
            function updateBudgetChart(chartId, labels, data) {
                const ctx = document.getElementById(chartId);
                if (!ctx) return;
                
                // Generate colors for each slice
                const colors = [
                    '#0ea5e9', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6',
                    '#06b6d4', '#84cc16', '#f97316', '#ec4899', '#6366f1'
                ];
                
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: colors.slice(0, labels.length),
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ¥' + context.parsed.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            function updateSpendingChart(chartId, labels, data, range, title) {
                const ctx = document.getElementById(chartId);
                if (!ctx) return;
                
                // Destroy existing chart if it exists
                if (window.spendingChart) {
                    window.spendingChart.destroy();
                }
                
                // Determine label based on range
                let labelText = 'Spending (¥)';
                switch(range) {
                    case 'week':
                        labelText = 'Daily Spending (¥)';
                        break;
                    case 'month':
                        labelText = 'Daily Spending (¥)';
                        break;
                    case 'year':
                        labelText = 'Monthly Spending (¥)';
                        break;
                }
                
                window.spendingChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: labelText,
                            data: data,
                            borderColor: '#0ea5e9',
                            backgroundColor: 'rgba(14, 165, 233, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0ea5e9',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: title ? true : false,
                                text: title,
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                padding: {
                                    bottom: 20
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Spent: ¥' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '¥' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        </script>
        
        @stack('scripts')
    </body>
</html>
