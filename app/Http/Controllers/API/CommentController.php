<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @param $profileId
     * @return JsonResponse
     */
    public function index($profileId): JsonResponse
    {
        $comments = Comment::where('user_info_id', $profileId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->successJsonResponse("Comments fetched", ['comments' => $comments]);
    }

    public function store(Request $request, $profileId): JsonResponse
    {
        $request->validate([
            'comment_text' => 'nullable|string',
            'comment_image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('comment_image')) {
            $imagePath = $request->file('comment_image')->store('comments', 'public');
        }

        $comment = Comment::create([
            'user_info_id' => $profileId,
            'comment_text' => $request->comment_text,
            'comment_image' => $imagePath,
        ]);

        return $this->successJsonResponse("Comments Stored", ['comment' => $comment]);
    }

}
