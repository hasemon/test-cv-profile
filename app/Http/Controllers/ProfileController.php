<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::latest()->get();
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'gender'=>'required',
            'avatar'=>'nullable|image|max:2048',
            'hobbies'=>'nullable|string'
        ]);

        if($request->hasFile('avatar')){
            $data['avatar'] = $request->file('avatar')->store('avatars','public');
        }

        $profile = Profile::create($data);
        return redirect()->route('profiles.show',$profile);
    }

    public function show(Profile $profile)
    {
        $profile->load('educations','comments');
        return view('profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'name'=>'required',
            'gender'=>'required',
            'avatar'=>'nullable|image|max:2048',
            'hobbies'=>'nullable|string'
        ]);

        if($request->hasFile('avatar')){
            if($profile->avatar) Storage::disk('public')->delete($profile->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars','public');
        }

        $profile->update($data);
        return redirect()->route('profiles.show',$profile);
    }

    public function destroy(Profile $profile)
    {
        if($profile->avatar) Storage::disk('public')->delete($profile->avatar);
        $profile->delete();
        return redirect()->route('profiles.index')->with('success','Profile deleted');
    }
}
