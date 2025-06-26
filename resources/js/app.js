import './bootstrap';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Budget overview chart
    const budgetOverviewCtx = document.getElementById('budgetOverviewChart');
    if (budgetOverviewCtx) {
        new Chart(budgetOverviewCtx, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        '#0ea5e9',
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#ec4899',
                        '#06b6d4',
                        '#84cc16'
                    ],
                    borderWidth: 0
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
                    }
                }
            }
        });
    }

    // Spending trends chart
    const spendingTrendsCtx = document.getElementById('spendingTrendsChart');
    if (spendingTrendsCtx) {
        new Chart(spendingTrendsCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Spending',
                    data: [],
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '¥' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});

// Utility functions for chart updates
window.updateBudgetChart = function(chartId, labels, data) {
    const chart = Chart.getChart(chartId);
    if (chart) {
        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.update();
    }
};

window.updateSpendingChart = function(chartId, labels, data) {
    const chart = Chart.getChart(chartId);
    if (chart) {
        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.update();
    }
};
