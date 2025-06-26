<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'color',
        'icon',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function currentMonthBudget(): ?Budget
    {
        return $this->budgets()
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->first();
    }

    public function getTotalAllocatedAttribute(): float
    {
        return $this->budgets()->sum('allocated_amount');
    }

    public function getTotalSpentAttribute(): float
    {
        return $this->budgets()->sum('spent_amount');
    }
}
