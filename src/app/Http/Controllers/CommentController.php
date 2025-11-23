<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function storecomment(CommentRequest $request)
    {
        Comment::create([
            'product_id' => $request->input('product_id'),
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('status', 'コメントを投稿しました！');
    }
}
