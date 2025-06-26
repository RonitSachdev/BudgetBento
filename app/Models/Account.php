<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'balance',
        'initial_balance',
        'currency',
        'description',
        'is_active',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'initial_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getFormattedBalanceAttribute(): string
    {
        return '¥' . number_format($this->balance, 0);
    }

    public function getAccountTypeIconAttribute(): string
    {
        return match($this->type) {
            'checking' => 'bank',
            'savings' => 'piggy-bank',
            'cash' => 'wallet',
            'credit' => 'credit-card',
            default => 'bank'
        };
    }
}
