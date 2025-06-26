<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Transaction::with(['account', 'category'])
            ->where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by account if provided
        if ($request->filled('account')) {
            $query->where('account_id', $request->account);
        }

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by type if provided
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payee', 'like', "%{$search}%")
                  ->orWhere('memo', 'like', "%{$search}%");
            });
        }

        $transactions = $query->paginate(25);
        
        // Get filter options
        $accounts = Account::where('user_id', $user->id)->where('is_active', true)->get();
        $categories = Category::where('user_id', $user->id)->where('is_active', true)->get();

        return view('transactions.index', compact('transactions', 'accounts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->where('is_active', true)->get();
        $categories = Category::where('user_id', $user->id)->where('is_active', true)->get();

        return view('transactions.create', compact('accounts', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'payee' => 'required|string|max:255',
            'memo' => 'nullable|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense,transfer',
            'transaction_date' => 'required|date',
        ]);

        // Convert amount to negative for expenses
        if ($validated['type'] === 'expense') {
            $validated['amount'] = -abs($validated['amount']);
        } else {
            $validated['amount'] = abs($validated['amount']);
        }

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->where('is_active', true)->get();
        $categories = Category::where('user_id', $user->id)->where('is_active', true)->get();

        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'payee' => 'required|string|max:255',
            'memo' => 'nullable|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense,transfer',
            'transaction_date' => 'required|date',
        ]);

        // Convert amount to negative for expenses
        if ($validated['type'] === 'expense') {
            $validated['amount'] = -abs($validated['amount']);
        } else {
            $validated['amount'] = abs($validated['amount']);
        }

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully!');
    }
}
