<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
        $profile = Profile::with('educations', 'comments')->first();
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
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/profile_images'), $imageName);
            $image_path = 'profile_images/' . $imageName;
        }

        Profile::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'hobby' => $request->hobby,
            'image' => $image_path,
        ]);

        return redirect()->route('profile.index');
    }

    public function edit(Profile $profile) {
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile) {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
        ]);

        if ($request->hasFile('image')) {
            if ($profile->image && file_exists(public_path('storage/' . $profile->image))) {
                unlink(public_path('storage/' . $profile->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/profile_images'), $imageName);
            $profile->image = 'profile_images/' . $imageName;
        }

        $profile->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'hobby' => $request->hobby,
        ]);

        return redirect()->route('profile.index');
    }

    public function destroy(Profile $profile) {
        if ($profile->image && file_exists(public_path('storage/' . $profile->image))) {
            unlink(public_path('storage/' . $profile->image));
        }

        $profile->delete();
        return redirect()->route('profile.index');
    }
}
