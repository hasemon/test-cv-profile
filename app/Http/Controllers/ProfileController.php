<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use App\Models\Comment;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index() {
        $profile = Profile::with('educations','comments')->first();
        return view('profile.index', compact('profile'));
    }


    public function create() {
        return view('profile.create');
    }


    public function store(Request $request) {
    $request->validate([
        'name' => 'required',
        'gender' => 'required',
    ]);

    $image_path = null;
    if($request->hasFile('image')){
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/profile_images'), $imageName);
        $image_path = 'profile_images/' . $imageName;
    }

    Profile::create([
        'name' => $request->name,
        'gender' => $request->gender,
        'hobby' => $request->hobby,
        'image' => $image_path
    ]);

    return redirect()->route('profile.index');
}



    public function edit(Profile $profile) {
        return view('profile.edit', compact('profile'));
    }


    public function update(Request $request, Profile $profile){
    $request->validate([
        'name' => 'required',
        'gender' => 'required',
    ]);

    if($request->hasFile('image')){
        
        if($profile->image){
            $oldImagePath = public_path('storage/' . $profile->image);
            if(file_exists($oldImagePath)){
                unlink($oldImagePath);
            }
        }

        
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/profile_images'), $imageName);
        $profile->image = 'profile_images/' . $imageName;
    }

    $profile->name = $request->name;
    $profile->gender = $request->gender;
    $profile->hobby = $request->hobby;
    $profile->save();

    return redirect()->route('profile.index');
}


    public function destroy(Profile $profile){
    if($profile->image){
        $imagePath = public_path('storage/' . $profile->image);
        if(file_exists($imagePath)){
            unlink($imagePath);
        }
    }
    $profile->delete();
    return redirect()->route('profile.index');
}



    public function storeEducation(Request $request){
        $request->validate([
            'degree'=>'required',
            'institute'=>'required',
            'session'=>'required',
            'ending'=>'required',
        ]);

        $profile = Profile::first();
        $profile->educations()->create($request->all());

        return back();
    }


    public function deleteEducation($id){
        Education::findOrFail($id)->delete();
        return back();
    }


    public function storeComment(Request $request){
    $request->validate([
        'comment' => 'required',
    ]);

    $image_path = null;
    if($request->hasFile('image')){
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/comments'), $imageName);
        $image_path = 'comments/' . $imageName;
    }

    $profile = Profile::first();
    $profile->comments()->create([
        'commenter_name' => $request->commenter_name,
        'comment' => $request->comment,
        'image' => $image_path
    ]);

    return back();
}



    public function deleteComment($id){
    $comment = Comment::findOrFail($id);

    if($comment->image){
        $image_path = public_path('storage/' . $comment->image);
        if(file_exists($image_path)){
            unlink($image_path);
        }
    }

    $comment->delete();
    return back();
}

}
