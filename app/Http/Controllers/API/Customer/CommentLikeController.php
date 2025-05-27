<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommentLike;

class CommentLikeController extends Controller
{
    
 public function toggleLike(Request $request, $comment_id)
{
    $user_id = $request->input('user_id');
    if (!$user_id) {
        return response()->json(['status' => false, 'message' => 'user_id مطلوب'], 400);
    }

    $like = CommentLike::where('comment_id', $comment_id)
        ->where('user_id', $user_id)
        ->first();

    if ($like) {
        $like->delete();
        return response()->json(['status' => true, 'liked' => false]);
    } else {
        CommentLike::create([
            'comment_id' => $comment_id,
            'user_id' => $user_id,
        ]);
        return response()->json(['status' => true, 'liked' => true]);
    }
}


    // عداد الإعجابات
    public function likesCount($comment_id)
    {
        $count = CommentLike::where('comment_id', $comment_id)->count();
        return response()->json(['status' => true, 'count' => $count]);
    }
}