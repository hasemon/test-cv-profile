<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'commenter_name'=>'nullable|string|max:100',
            'text'=>'nullable|string',
            'image'=>'nullable|image|max:4096'
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('comments','public');
        }

        $profile->comments()->create($data);
        return back();
    }
}
