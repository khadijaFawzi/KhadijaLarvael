<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductReview;
class ProductReviewController extends Controller
{
     public function index(Product $product)
    {
        return $product->reviews()->with('user')->latest()->get();
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            
        ]);
        $review = ProductReview::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'rating' => $data['rating'],
            
        ]);
        return response()->json($review->load('user'), 201);
    }
}
