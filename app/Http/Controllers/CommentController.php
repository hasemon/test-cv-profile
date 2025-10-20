<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('comments', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['profile_id'] = $profile->id;

        Comment::create($validated);

        return back()->with('success', 'Comment added.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
