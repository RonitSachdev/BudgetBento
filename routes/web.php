<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecurringTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/api/budget-data', [DashboardController::class, 'getBudgetData'])->name('api.budget-data');
    Route::get('/api/spending-trends', [DashboardController::class, 'getSpendingTrends'])->name('api.spending-trends');
    Route::get('/api/available-periods', [DashboardController::class, 'getAvailablePeriods'])->name('api.available-periods');
    
    Route::resource('budgets', BudgetController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('recurring-transactions', RecurringTransactionController::class);
    Route::patch('/recurring-transactions/{recurringTransaction}/toggle', [RecurringTransactionController::class, 'toggle'])->name('recurring-transactions.toggle');
    Route::post('/recurring-transactions/process-due', [RecurringTransactionController::class, 'processDue'])->name('recurring-transactions.process-due');
    
    Route::post('/budgets/allocate', [BudgetController::class, 'allocate'])->name('budgets.allocate');
    Route::get('/budgets/month/{month}/year/{year}', [BudgetController::class, 'showMonth'])->name('budgets.month');
});

require __DIR__.'/auth.php';
