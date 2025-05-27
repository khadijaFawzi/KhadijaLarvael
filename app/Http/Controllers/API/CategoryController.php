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
    $products = $category->products->map(function ($product) {
        return [
            'id'            => $product->id,
            'name'          => $product->product_name,
            'price'         => $product->Price,
            'image_url'     => asset('products/' . $product->Image),
            'category_id'   => $product->Category_id,
            'supermarket_id'=> $product->supermarket_id,
            'barcode'       => $product->barcode,
            'description'   => $product->Description,
        ];
    });
    return response()->json([
        'status'   => true,
        'category' => [
            'id'           => $category->id,
            'CategoryName' => $category->CategoryName,
            'icon'         => $category->icon ? asset("storage/icons/{$category->icon}") : null,
        ],
        'products' => $products,
    ]);
}

public function productsByCategory($id)
{
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['status' => false, 'message' => 'Category not found'], 404);
    }
    $products = $category->products->map(function ($product) {
        return [
            'id'            => $product->id,
            'name'          => $product->product_name,
            'price'         => $product->Price,
            'image_url'     => asset('products/' . $product->Image),
            'category_id'   => $product->Category_id,       // مهم!
            'supermarket_id'=> $product->supermarket_id,    // مهم!
            'barcode'       => $product->barcode,
            'description'   => $product->Description,
        ];
    });
    return response()->json(['status' => true, 'products' => $products]);
}


public function categoriesBySupermarket($supermarketId)
{
    // جلب كل الفئات التي لديها منتجات في هذا السوبرماركت
    $categoryIds = \App\Models\Product::where('supermarket_id', $supermarketId)
        ->pluck('Category_id')
        ->unique();

    $categories = \App\Models\Category::whereIn('id', $categoryIds)->get();

    return response()->json([
        'status' => true,
        'categories' => $categories->map(fn($c) => [
            'id'           => $c->id,
            'CategoryName' => $c->CategoryName,
            'icon'         => $c->icon 
                ? asset("storage/icons/{$c->icon}") 
                : null,
        ]),
    ]);
}

}