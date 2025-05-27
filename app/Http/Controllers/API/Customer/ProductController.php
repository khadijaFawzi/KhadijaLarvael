<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
  public function getAllProducts()
{
    $products = Product::with(['category', 'supermarket'])->get()->map(function ($product) {
        return [
            'id'            => $product->id,
            'name'          => $product->product_name,
            'price'         => $product->Price,
            'image_url'     => asset('products/' . $product->Image),
            'category_id'   => $product->Category_id, // أضف هذا
            'supermarket_id'=> $product->supermarket_id, // أضف هذا
            'category'      => $product->category->CategoryName ?? 'غير محددة',
            'supermarket'   => $product->supermarket->SupermarketName ?? 'غير معروف',
            'barcode'       => $product->barcode,
            'description'   => $product->Description,
        ];
    });

    return response()->json([
        'status'   => true,
        'products' => $products,
    ]);
}

public function getProductsBySupermarket($supermarketId)
{
    $products = Product::with(['category', 'supermarket'])
        ->where('supermarket_id', $supermarketId)
        ->get()
        ->map(function ($product) {
            return [
                'id'            => $product->id,
                'name'          => $product->product_name,
                'price'         => $product->Price,
                'image_url'     => asset('products/' . $product->Image),
                'category_id'   => $product->Category_id,
                'supermarket_id'=> $product->supermarket_id,
                'category'      => $product->category->CategoryName ?? 'غير محددة',
                'supermarket'   => $product->supermarket->SupermarketName ?? 'غير معروف',
                'barcode'       => $product->barcode,
                'description'   => $product->Description,
            ];
        });

    return response()->json([
        'status'   => true,
        'products' => $products,
    ]);
}
public function comparePricesByBarcode($barcode)
{
    $items = Product::with('supermarket')
        ->where('barcode', $barcode)
        ->get();

    if ($items->isEmpty()) {
        return response()->json([
            'status'  => false,
            'message' => 'لا يوجد منتج بهذا الباركود'
        ], 404);
    }

    $offers = $items->map(function($item) {
        return [
            'supermarket_id'   => $item->supermarket_id,
            'supermarket_name' => $item->supermarket->SupermarketName ?? '',
            'price'            => $item->Price,
            'image_url'        => asset('products/' . $item->Image),
        ];
    })->toArray();

    $allPrices = array_column($offers, 'price');
    $minPrice = min($allPrices);
    $maxPrice = max($allPrices);
    $saving  = $maxPrice - $minPrice;

    return response()->json([
        'status'         => true,
        'barcode'        => $barcode,
        'product_name'   => $items->first()->product_name,
        'min_price'      => $minPrice,
        'max_price'      => $maxPrice,
        'saving'         => $saving,
        'price_offers'   => $offers,
    ]);
}

public function getProductsBySupermarketAndCategory($supermarketId, $categoryId)
{
    $products = \App\Models\Product::with(['category', 'supermarket'])
        ->where('supermarket_id', $supermarketId)
        ->where('Category_id', $categoryId)
        ->get()
        ->map(function ($product) {
            return [
                'id'            => $product->id,
                'name'          => $product->product_name,
                'price'         => $product->Price,
                'image_url'     => asset('products/' . $product->Image),
                'category_id'   => $product->Category_id,
                'supermarket_id'=> $product->supermarket_id,
                'category'      => $product->category->CategoryName ?? 'غير محددة',
                'supermarket'   => $product->supermarket->SupermarketName ?? 'غير معروف',
                'barcode'       => $product->barcode,
                'description'   => $product->Description,
            ];
        });

    return response()->json([
        'status'   => true,
        'products' => $products,
    ]);
}
 // ProductController.php
public function similar($id)
{
    $product = Product::findOrFail($id);

    // جلب منتجات من نفس الفئة مع استثناء المنتج الحالي
    $similar = Product::where('Category_id', $product->Category_id)
        ->where('id', '!=', $product->id)
        ->limit(8) // عدد المنتجات المشابهة
        ->get();

    return response()->json(['status' => true, 'products' => $similar]);
}

}
