<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'month',
        'year',
        'allocated_amount',
        'spent_amount',
        'available_amount',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'allocated_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'available_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedAllocatedAmountAttribute(): string
    {
        return '¥' . number_format($this->allocated_amount, 0);
    }

    public function getFormattedSpentAmountAttribute(): string
    {
        return '¥' . number_format($this->spent_amount, 0);
    }

    public function getFormattedAvailableAmountAttribute(): string
    {
        return '¥' . number_format($this->available_amount, 0);
    }

    public function getSpentPercentageAttribute(): float
    {
        if ($this->allocated_amount == 0) {
            return 0;
        }
        return ($this->spent_amount / $this->allocated_amount) * 100;
    }

    public function getIsOverBudgetAttribute(): bool
    {
        return $this->spent_amount > $this->allocated_amount;
    }

    public function updateSpentAmount(): void
    {
        $this->spent_amount = $this->category->transactions()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $this->month)
            ->whereYear('transaction_date', $this->year)
            ->sum('amount') * -1; // Convert negative to positive
        
        $this->available_amount = $this->allocated_amount - $this->spent_amount;
        $this->save();
    }
}
