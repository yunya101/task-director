<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store($group, $task, Request $request) {
        $validated = $request->validate([
            'text' => ['string', 'required', 'max:500'],
        ]);

        Comment::create([
            'text' => $validated['text'],
            'user_id' => Auth::id(),
            'task_id' => $task,
            'group_id' => $group,
        ]);

        return back();
    }
}
