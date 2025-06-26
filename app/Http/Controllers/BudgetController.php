<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get or create categories for this user
        $categories = Category::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get budgets for current month
        $budgets = Budget::with('category')
            ->where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get()
            ->keyBy('category_id');

        // Calculate totals
        $totalAllocated = $budgets->sum('allocated_amount');
        $totalSpent = $budgets->sum('spent_amount');
        $totalAvailable = $totalAllocated - $totalSpent;

        return view('budgets.index', compact(
            'categories',
            'budgets',
            'totalAllocated',
            'totalSpent',
            'totalAvailable',
            'currentMonth',
            'currentYear'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('budgets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'allocated_amount' => 'required|numeric|min:0',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $budget = Budget::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'month' => $validated['month'],
                'year' => $validated['year'],
            ],
            [
                'allocated_amount' => $validated['allocated_amount'],
                'available_amount' => $validated['allocated_amount'] - (Budget::where([
                    'user_id' => Auth::id(),
                    'category_id' => $validated['category_id'],
                    'month' => $validated['month'],
                    'year' => $validated['year'],
                ])->first()->spent_amount ?? 0),
            ]
        );

        return redirect()->route('budgets.index')
            ->with('success', 'Budget allocation updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        return view('budgets.show', compact('budget'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::where('user_id', Auth::id())
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('budgets.edit', compact('budget', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'allocated_amount' => 'required|numeric|min:0',
        ]);

        $budget->update([
            'allocated_amount' => $validated['allocated_amount'],
            'available_amount' => $validated['allocated_amount'] - $budget->spent_amount,
        ]);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully!');
    }

    public function allocate(Request $request)
    {
        $validated = $request->validate([
            'allocations' => 'required|array',
            'allocations.*.category_id' => 'required|exists:categories,id',
            'allocations.*.amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        foreach ($validated['allocations'] as $allocation) {
            Budget::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'category_id' => $allocation['category_id'],
                    'month' => $currentMonth,
                    'year' => $currentYear,
                ],
                [
                    'allocated_amount' => $allocation['amount'],
                    'available_amount' => $allocation['amount'] - (Budget::where([
                        'user_id' => $user->id,
                        'category_id' => $allocation['category_id'],
                        'month' => $currentMonth,
                        'year' => $currentYear,
                    ])->first()->spent_amount ?? 0),
                ]
            );
        }

        return redirect()->route('budgets.index')
            ->with('success', 'Budget allocations updated successfully!');
    }

    public function showMonth($month, $year)
    {
        $user = Auth::user();

        // Get categories
        $categories = Category::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get budgets for specified month
        $budgets = Budget::with('category')
            ->where('user_id', $user->id)
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->keyBy('category_id');

        // Calculate totals
        $totalAllocated = $budgets->sum('allocated_amount');
        $totalSpent = $budgets->sum('spent_amount');
        $totalAvailable = $totalAllocated - $totalSpent;

        return view('budgets.index', compact(
            'categories',
            'budgets',
            'totalAllocated',
            'totalSpent',
            'totalAvailable',
            'month',
            'year'
        ));
    }
}
