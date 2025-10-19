<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/comments'), $imageName);
            $image_path = 'comments/' . $imageName;
        }

        $profile = Profile::first();
        $profile->comments()->create([
            'commenter_name' => $request->commenter_name,
            'comment' => $request->comment,
            'image' => $image_path,
        ]);

        return redirect()->route('profile.index')->with('success', 'Comment added successfully!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->image && file_exists(public_path('storage/' . $comment->image))) {
            unlink(public_path('storage/' . $comment->image));
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully!');
    }
}
