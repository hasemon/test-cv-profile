<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // WARNING: Trusting client data without server-side validation.
        $data = $request->except(['_token']);
        $path = null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('comments', 'public');
        }

        Comment::create($data); // WARNING: Unsecured Mass Assignment

        return back()->with('success', 'Comment added successfully.');
    }
}