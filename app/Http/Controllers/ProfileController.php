<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with('educations', 'comments.user')->get();
        return Inertia::render('Profiles/Index', [
            'profiles' => $profiles
        ]);
    }

    public function create()
    {
        return Inertia::render('Profiles/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'hobbies' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validated['user_id'] = auth()->id();

        Profile::create($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }

    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile);
        return Inertia::render('Profiles/Edit', ['profile' => $profile]);
    }
    public function show(Profile $profile)
{
    $profile->load(['educations', 'comments.user']);
    return Inertia::render('Profiles/Show', [
        'profile' => $profile,
    ]);
}


    public function update(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'hobbies' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->update($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);
        if ($profile->avatar) {
            Storage::disk('public')->delete($profile->avatar);
        }
        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }
}
