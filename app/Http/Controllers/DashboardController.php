<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Check setup completion
        $hasAccounts = Account::where('user_id', $user->id)->where('is_active', true)->exists();
        $hasCategories = Category::where('user_id', $user->id)->exists();
        $setupComplete = $hasAccounts && $hasCategories;

        // If setup is not complete, return early with setup data
        if (!$setupComplete) {
            return view('dashboard', compact(
                'hasAccounts',
                'hasCategories', 
                'setupComplete'
            ));
        }

        // Get current month budgets with category information
        $budgets = Budget::with('category')
            ->where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        // Get accounts summary
        $accounts = Account::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        // Get recent transactions
        $recentTransactions = Transaction::with(['account', 'category'])
            ->where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Calculate summary statistics
        $totalNetWorth = $accounts->sum('balance');
        $totalBudgeted = $budgets->sum('allocated_amount');
        $totalSpent = $budgets->sum('spent_amount');
        $totalAvailable = $totalBudgeted - $totalSpent;

        // Get monthly income vs expenses for the last 6 months
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $income = Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('amount');

            $expenses = abs(Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('amount'));

            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'income' => $income,
                'expenses' => $expenses,
                'net' => $income - $expenses
            ];
        }

        // Get spending by category for current month (for pie chart)
        $categorySpending = Transaction::with('category')
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->get()
            ->groupBy('category.name')
            ->map(function ($transactions) {
                return [
                    'amount' => abs($transactions->sum('amount')),
                    'color' => $transactions->first()->category->color ?? '#6b7280'
                ];
            });

        // Budget progress (categories that are over/under budget)
        $budgetAlerts = $budgets->filter(function ($budget) {
            return $budget->spent_amount > $budget->allocated_amount * 0.8; // 80% threshold
        });

        return view('dashboard', compact(
            'budgets',
            'accounts', 
            'recentTransactions',
            'totalNetWorth',
            'totalBudgeted',
            'totalSpent',
            'totalAvailable',
            'monthlyData',
            'categorySpending',
            'budgetAlerts',
            'hasAccounts',
            'hasCategories',
            'setupComplete'
        ));
    }

    public function getBudgetData()
    {
        $user = Auth::user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $budgets = Budget::with('category')
            ->where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        $labels = $budgets->pluck('category.name')->toArray();
        $spent = $budgets->pluck('spent_amount')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $spent
        ]);
    }

    public function getAvailablePeriods(Request $request)
    {
        $user = Auth::user();
        $range = $request->get('range', 'month');
        
        // Get all unique periods that have transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->orderBy('transaction_date', 'desc')
            ->get();

        $periods = [];
        $current = null;

        switch ($range) {
            case 'week':
                $weekPeriods = $transactions->groupBy(function($transaction) {
                    return $transaction->transaction_date->startOfWeek()->format('Y-m-d');
                })->keys();

                foreach ($weekPeriods as $weekStart) {
                    $date = Carbon::parse($weekStart);
                    $periods[] = [
                        'value' => $weekStart,
                        'label' => $date->format('M d, Y') . ' - ' . $date->copy()->endOfWeek()->format('M d, Y')
                    ];
                }
                
                $current = now()->startOfWeek()->format('Y-m-d');
                break;

            case 'year':
                $yearPeriods = $transactions->groupBy(function($transaction) {
                    return $transaction->transaction_date->year;
                })->keys();

                foreach ($yearPeriods as $year) {
                    $periods[] = [
                        'value' => (string)$year,
                        'label' => (string)$year
                    ];
                }
                
                $current = (string)now()->year;
                break;

            case 'month':
            default:
                $monthPeriods = $transactions->groupBy(function($transaction) {
                    return $transaction->transaction_date->format('Y-m');
                })->keys();

                foreach ($monthPeriods as $month) {
                    $date = Carbon::createFromFormat('Y-m', $month);
                    $periods[] = [
                        'value' => $month,
                        'label' => $date->format('F Y')
                    ];
                }
                
                $current = now()->format('Y-m');
                break;
        }

        return response()->json([
            'periods' => $periods,
            'current' => $current
        ]);
    }

    public function getSpendingTrends(Request $request)
    {
        $user = Auth::user();
        $range = $request->get('range', 'month');
        $period = $request->get('period');
        $data = [];
        $title = '';

        switch ($range) {
            case 'week':
                $startDate = Carbon::parse($period)->startOfWeek();
                $endDate = Carbon::parse($period)->endOfWeek();
                $title = $startDate->format('M d') . ' - ' . $endDate->format('M d, Y');
                
                // Get daily spending for the week
                for ($i = 0; $i < 7; $i++) {
                    $date = $startDate->copy()->addDays($i);
                    
                    $expenses = abs(Transaction::where('user_id', $user->id)
                        ->where('type', 'expense')
                        ->whereDate('transaction_date', $date)
                        ->sum('amount'));

                    $data[] = [
                        'label' => $date->format('D'),
                        'amount' => $expenses
                    ];
                }
                break;

            case 'year':
                $year = (int)$period;
                $title = $year;
                
                // Get monthly spending for the year
                for ($month = 1; $month <= 12; $month++) {
                    $expenses = abs(Transaction::where('user_id', $user->id)
                        ->where('type', 'expense')
                        ->whereYear('transaction_date', $year)
                        ->whereMonth('transaction_date', $month)
                        ->sum('amount'));

                    $data[] = [
                        'label' => Carbon::create($year, $month)->format('M'),
                        'amount' => $expenses
                    ];
                }
                break;

            case 'month':
            default:
                $date = Carbon::createFromFormat('Y-m', $period);
                $title = $date->format('F Y');
                
                // Get daily spending for the month
                $daysInMonth = $date->daysInMonth;
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $currentDate = $date->copy()->day($day);
                    
                    $expenses = abs(Transaction::where('user_id', $user->id)
                        ->where('type', 'expense')
                        ->whereDate('transaction_date', $currentDate)
                        ->sum('amount'));

                    $data[] = [
                        'label' => (string)$day,
                        'amount' => $expenses
                    ];
                }
                break;
        }

        return response()->json([
            'labels' => collect($data)->pluck('label')->toArray(),
            'data' => collect($data)->pluck('amount')->toArray(),
            'title' => $title,
            'range' => $range
        ]);
    }
}
