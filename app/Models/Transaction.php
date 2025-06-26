<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'payee',
        'memo',
        'amount',
        'type',
        'transaction_date',
        'cleared',
        'approved',
        'recurring_transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'cleared' => 'boolean',
        'approved' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function recurringTransaction(): BelongsTo
    {
        return $this->belongsTo(RecurringTransaction::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        $formatted = '¥' . number_format(abs($this->amount), 0);
        return $this->amount < 0 ? '-' . $formatted : '+' . $formatted;
    }

    public function getAbsoluteAmountAttribute(): float
    {
        return abs($this->amount);
    }

    public function getIsIncomeAttribute(): bool
    {
        return $this->amount > 0;
    }

    public function getIsExpenseAttribute(): bool
    {
        return $this->amount < 0;
    }

    public function getTransactionIconAttribute(): string
    {
        return match($this->type) {
            'income' => 'arrow-down-circle',
            'expense' => 'arrow-up-circle',
            'transfer' => 'arrow-right-left',
            default => 'circle'
        };
    }

    public function getTransactionColorAttribute(): string
    {
        return match($this->type) {
            'income' => 'text-success-600',
            'expense' => 'text-danger-600',
            'transfer' => 'text-primary-600',
            default => 'text-gray-600'
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($transaction) {
            // Update account balance
            $transaction->account->balance += $transaction->amount;
            $transaction->account->save();

            // Update budget spent amount if it's an expense
            if ($transaction->type === 'expense' && $transaction->category_id) {
                $budget = Budget::firstOrCreate([
                    'user_id' => $transaction->user_id,
                    'category_id' => $transaction->category_id,
                    'month' => $transaction->transaction_date->month,
                    'year' => $transaction->transaction_date->year,
                ]);
                $budget->updateSpentAmount();
            }
        });

        static::updated(function ($transaction) {
            // Recalculate account balance and budget amounts
            $transaction->updateRelatedBalances();
        });

        static::deleted(function ($transaction) {
            // Update account balance
            $transaction->account->balance -= $transaction->amount;
            $transaction->account->save();

            // Update budget if needed
            if ($transaction->type === 'expense' && $transaction->category_id) {
                $budget = Budget::where([
                    'user_id' => $transaction->user_id,
                    'category_id' => $transaction->category_id,
                    'month' => $transaction->transaction_date->month,
                    'year' => $transaction->transaction_date->year,
                ])->first();
                
                if ($budget) {
                    $budget->updateSpentAmount();
                }
            }
        });
    }

    private function updateRelatedBalances()
    {
        // This would need to be implemented based on specific business logic
        // for handling balance updates when transactions are modified
    }
}
