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
            'icon'          => $c->icon,     // أضفناه هنا
        ]),
    ], 200);
}

}