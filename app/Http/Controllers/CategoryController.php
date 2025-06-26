<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|size:7',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['sort_order'] = Category::where('user_id', Auth::id())->max('sort_order') + 1;
        $validated['is_active'] = true;

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Check if the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to category.');
        }
        
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Check if the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to category.');
        }
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Check if the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to category.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|size:7',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to category.');
        }
        
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
