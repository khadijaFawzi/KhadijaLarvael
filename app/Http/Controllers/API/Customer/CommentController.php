<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
  public function index(Request $request)
{
    $query = Comment::query();

    if ($request->has('product_id')) {
        $query->where('product_id', $request->product_id);
    }
    if ($request->has('food_basket_id')) {
        $query->where('food_basket_id', $request->food_basket_id);
    }

    $comments = $query->with('user')->latest()->get();

    return response()->json([
        'status' => true,
        'comments' => $comments->map(function($comment) {
            return [
                'id' => $comment->id,
                'product_id' => $comment->product_id,
                'body' => $comment->body,
                'user_id' => $comment->user_id,
                'user_name' => $comment->user ? $comment->user->username : 'مجهول',
                'created_at' => $comment->created_at ? $comment->created_at->toIso8601String() : null,
                'likes_count' => $comment->likes()->count(), // <-- هذا السطر المهم
            ];
        })
    ]);
}





    // إضافة تعليق
    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => 'required|string|max:2000',
            'product_id' => 'nullable|exists:products,id',
            'food_basket_id' => 'nullable|exists:food_baskets,id',
            'user_id' => 'nullable|exists:users,id', // التحقق من صحة user_id
        ]);

        // التحقق إذا لم يتم إرسال user_id، تعيينه إلى 1 (أو قيمة افتراضية أخرى)
        if (!$data['user_id']) {
            $data['user_id'] = 1; // أو تعيينه إلى قيمة افتراضية مثل 1
        }

        try {
            // إضافة التعليق إلى قاعدة البيانات
            $comment = Comment::create($data);
            return response()->json([
                'status' => true,
                'comment' => $comment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء إضافة التعليق',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // حذف تعليق
    public function destroy($id, Request $request)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['status' => true, 'message' => 'تم حذف التعليق']);
    }
}