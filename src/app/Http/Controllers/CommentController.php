<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id) {
        $body = $request->validated();
        Comment::create($body + [
            'item_id' => $item_id,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('items.show', $item_id);
    }
}
