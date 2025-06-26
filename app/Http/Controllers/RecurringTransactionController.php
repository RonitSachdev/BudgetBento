<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\RecurringTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecurringTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = RecurringTransaction::with(['account', 'category'])
            ->where('user_id', $user->id);

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Filter by frequency
        if ($request->has('frequency') && $request->frequency !== '') {
            $query->where('frequency', $request->frequency);
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%");
            });
        }

        $recurringTransactions = $query->orderBy('next_due_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get upcoming transactions (next 7 days)
        $upcomingTransactions = RecurringTransaction::with(['account', 'category'])
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->where('next_due_date', '<=', now()->addDays(7))
            ->orderBy('next_due_date', 'asc')
            ->get();

        return view('recurring-transactions.index', compact(
            'recurringTransactions', 
            'upcomingTransactions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        $accounts = Account::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();
        
        $categories = Category::where('user_id', $user->id)->get();

        return view('recurring-transactions.create', compact('accounts', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense,transfer',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'interval' => 'required|integer|min:1|max:365',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'max_occurrences' => 'nullable|integer|min:1|max:1000',
        ]);

        // Verify account ownership
        $account = Account::where('id', $validated['account_id'])
            ->where('user_id', $user->id)
            ->first();
        
        if (!$account) {
            return back()->withErrors(['account_id' => 'Invalid account selected.']);
        }

        // Verify category ownership if provided
        if ($validated['category_id']) {
            $category = Category::where('id', $validated['category_id'])
                ->where('user_id', $user->id)
                ->first();
            
            if (!$category) {
                return back()->withErrors(['category_id' => 'Invalid category selected.']);
            }
        }

        $validated['user_id'] = $user->id;
        $validated['next_due_date'] = $validated['start_date'];

        RecurringTransaction::create($validated);

        return redirect()->route('recurring-transactions.index')
            ->with('success', 'Recurring transaction created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecurringTransaction $recurringTransaction)
    {
        if ($recurringTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $recurringTransaction->load(['account', 'category', 'transactions' => function($query) {
            $query->orderBy('transaction_date', 'desc')->limit(20);
        }]);

        return view('recurring-transactions.show', compact('recurringTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecurringTransaction $recurringTransaction)
    {
        if ($recurringTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        
        $accounts = Account::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();
        
        $categories = Category::where('user_id', $user->id)->get();

        return view('recurring-transactions.edit', compact('recurringTransaction', 'accounts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecurringTransaction $recurringTransaction)
    {
        if ($recurringTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense,transfer',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'interval' => 'required|integer|min:1|max:365',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'max_occurrences' => 'nullable|integer|min:1|max:1000',
            'is_active' => 'boolean',
        ]);

        // Verify account ownership
        $account = Account::where('id', $validated['account_id'])
            ->where('user_id', $user->id)
            ->first();
        
        if (!$account) {
            return back()->withErrors(['account_id' => 'Invalid account selected.']);
        }

        // Verify category ownership if provided
        if ($validated['category_id']) {
            $category = Category::where('id', $validated['category_id'])
                ->where('user_id', $user->id)
                ->first();
            
            if (!$category) {
                return back()->withErrors(['category_id' => 'Invalid category selected.']);
            }
        }

        // If frequency or interval changed, recalculate next due date
        if ($recurringTransaction->frequency !== $validated['frequency'] || 
            $recurringTransaction->interval !== $validated['interval']) {
            $validated['next_due_date'] = $recurringTransaction->calculateNextDueDate();
        }

        $recurringTransaction->update($validated);

        return redirect()->route('recurring-transactions.index')
            ->with('success', 'Recurring transaction updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecurringTransaction $recurringTransaction)
    {
        if ($recurringTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $recurringTransaction->delete();

        return redirect()->route('recurring-transactions.index')
            ->with('success', 'Recurring transaction deleted successfully!');
    }

    /**
     * Toggle active status of recurring transaction
     */
    public function toggle(RecurringTransaction $recurringTransaction)
    {
        if ($recurringTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $recurringTransaction->update([
            'is_active' => !$recurringTransaction->is_active
        ]);

        $status = $recurringTransaction->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Recurring transaction {$status} successfully!");
    }

    /**
     * Process due recurring transactions
     */
    public function processDue()
    {
        $user = Auth::user();
        $processed = 0;

        $dueTransactions = RecurringTransaction::where('user_id', $user->id)
            ->where('is_active', true)
            ->where('next_due_date', '<=', now()->toDateString())
            ->get();

        foreach ($dueTransactions as $recurring) {
            if ($recurring->shouldCreateTransaction()) {
                $recurring->createTransaction();
                $processed++;
            }
        }

        return back()->with('success', "Processed {$processed} recurring transactions!");
    }
}
