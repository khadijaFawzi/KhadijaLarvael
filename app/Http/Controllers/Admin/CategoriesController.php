<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display the add‐category form (and list existing).
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.add', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'CategoryName' => 'required|string|max:255',
            'icon'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2. Handle icon upload
        $iconName = null;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $iconName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            // stores in storage/app/public/icons
            $file->storeAs('public/icons', $iconName);
        }

        // 3. Create category
        Category::create([
            'CategoryName' => $request->CategoryName,
            'icon'         => $iconName,
        ]);

        // 4. Redirect back with success message
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تمت إضافة الفئة بنجاح');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'CategoryName' => 'required|string|max:255',
            'icon'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // If new icon uploaded, delete old and store new
        if ($request->hasFile('icon')) {
            if ($category->icon) {
                Storage::delete("public/icons/{$category->icon}");
            }
            $file = $request->file('icon');
            $iconName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/icons', $iconName);
            $category->icon = $iconName;
        }

        $category->CategoryName = $request->CategoryName;
        $category->save();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // delete icon file if exists
        if ($category->icon) {
            Storage::delete("public/icons/{$category->icon}");
        }
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم حذف الفئة بنجاح');
    }
}
