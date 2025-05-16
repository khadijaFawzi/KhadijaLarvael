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
                'category'      => $product->category->CategoryName ?? 'غير محددة',
                'supermarket'   => $product->supermarket->name ?? 'غير معروف',
                'barcode'       => $product->barcode,
                'description'   => $product->Description,
            ];
        });

        return response()->json([
            'status'   => true,
            'products' => $products,
        ]);
    }

}
