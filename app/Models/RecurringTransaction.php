<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'description',
        'amount',
        'type',
        'frequency',
        'interval',
        'start_date',
        'end_date',
        'next_due_date',
        'max_occurrences',
        'occurrences_created',
        'is_active',
        'metadata'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'next_due_date' => 'date',
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'recurring_transaction_id');
    }

    // Methods
    public function shouldCreateTransaction()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->next_due_date > now()->toDateString()) {
            return false;
        }

        if ($this->end_date && $this->next_due_date > $this->end_date) {
            return false;
        }

        if ($this->max_occurrences && $this->occurrences_created >= $this->max_occurrences) {
            return false;
        }

        return true;
    }

    public function calculateNextDueDate()
    {
        $currentDue = Carbon::parse($this->next_due_date);
        
        switch ($this->frequency) {
            case 'daily':
                return $currentDue->addDays($this->interval);
            case 'weekly':
                return $currentDue->addWeeks($this->interval);
            case 'monthly':
                return $currentDue->addMonths($this->interval);
            case 'yearly':
                return $currentDue->addYears($this->interval);
            default:
                return $currentDue;
        }
    }

    public function createTransaction()
    {
        $transaction = Transaction::create([
            'user_id' => $this->user_id,
            'account_id' => $this->account_id,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'amount' => $this->type === 'expense' ? -abs($this->amount) : abs($this->amount),
            'type' => $this->type,
            'transaction_date' => $this->next_due_date,
            'recurring_transaction_id' => $this->id
        ]);

        // Update account balance
        $account = $this->account;
        if ($this->type === 'income') {
            $account->balance += abs($this->amount);
        } else {
            $account->balance -= abs($this->amount);
        }
        $account->save();

        // Update budget spent amount if it's an expense
        if ($this->type === 'expense' && $this->category_id) {
            $currentMonth = $this->next_due_date->month;
            $currentYear = $this->next_due_date->year;
            
            $budget = Budget::where('user_id', $this->user_id)
                ->where('category_id', $this->category_id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->first();
                
            if ($budget) {
                $budget->spent_amount += abs($this->amount);
                $budget->save();
            }
        }

        // Update recurring transaction
        $this->occurrences_created++;
        $this->next_due_date = $this->calculateNextDueDate();
        
        // Check if we should deactivate
        if ($this->end_date && $this->next_due_date > $this->end_date) {
            $this->is_active = false;
        }
        
        if ($this->max_occurrences && $this->occurrences_created >= $this->max_occurrences) {
            $this->is_active = false;
        }
        
        $this->save();

        return $transaction;
    }

    public function getFrequencyDisplayAttribute()
    {
        $frequency = ucfirst($this->frequency);
        if ($this->interval > 1) {
            $plural = $this->frequency === 'daily' ? 'days' : 
                     ($this->frequency === 'weekly' ? 'weeks' : 
                     ($this->frequency === 'monthly' ? 'months' : 'years'));
            return "Every {$this->interval} {$plural}";
        }
        return $frequency;
    }
}
