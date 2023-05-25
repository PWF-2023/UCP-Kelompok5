<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->user()->id)
            ->orderBy('tittle', 'asc')
            ->get();
        return view('category.index', compact('categories'));
    }
    public function create()
    {
        return view('category.create');
    }
    public function edit(Category $category)
    {
        if (auth()->user()->id == $category->user_id){
            return view('category.edit', compact('category'));
        } else {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to edit this category!');
        }
    }
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'tittle' => 'required|max:255',
        ]);
        $category = Category::create([
            'tittle' => ucfirst($request->tittle),
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('category.index')->with('success', 'Category Created Successfully!');
    }
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'tittle' => 'required|max:255',
        ]);

        $category->update([
            'tittle' => ucfirst($request->tittle),
        ]);
        return redirect()->route('category.index')->with('success', 'Category Updated Successfully!');
    }
    public function destroy(Category $category)
    {
        if (auth()->user()->id == $category->user_id) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Category Deleted Successfully!');
        } else {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to delete this category!');
        }
    }
}