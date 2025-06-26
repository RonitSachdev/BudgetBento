<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,cash,credit',
            'initial_balance' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['balance'] = $validated['initial_balance'];
        $validated['is_active'] = true;

        Account::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        // Check if the account belongs to the authenticated user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to account.');
        }
        
        return view('accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        // Check if the account belongs to the authenticated user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to account.');
        }
        
        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        // Check if the account belongs to the authenticated user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to account.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,cash,credit',
            'description' => 'nullable|string',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        // Check if the account belongs to the authenticated user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to account.');
        }
        
        $account->update(['is_active' => false]);

        return redirect()->route('accounts.index')
            ->with('success', 'Account deactivated successfully!');
    }
}
