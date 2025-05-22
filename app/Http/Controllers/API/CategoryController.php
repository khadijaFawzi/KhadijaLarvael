<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
public function index(): JsonResponse
{
    $categories = Category::all();

    return response()->json([
        'status'     => true,
        'categories' => $categories->map(fn($c) => [
            'id'            => $c->id,
            'CategoryName'  => $c->CategoryName,
            'icon'          => $c->icon 
                ? asset("storage/icons/{$c->icon}") 
                : null,
        ]),
    ], 200);
}
public function show($id)
{
    $category = Category::with('products')->find($id);
    if (!$category) {
        return response()->json(['status' => false, 'message' => 'Category not found'], 404);
    }
    return response()->json([
        'status' => true,
        'category' => $category,
        'products' => $category->products
    ]);
}
public function productsByCategory($id)
{
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['status' => false, 'message' => 'Category not found'], 404);
    }
    $products = $category->products;
    return response()->json(['status' => true, 'products' => $products]);
}


}