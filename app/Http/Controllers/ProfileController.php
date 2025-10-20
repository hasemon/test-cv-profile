<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function create()
    {
        $profile = Profile::first();

        return view('profiles.create', compact('profile'));
    }

    public function store(Request $request)
    {

        if (Profile::exists()) {
            return redirect()->route('profile.show')->with('error', 'A profile already exists.');
        }


        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'hobbies' => 'nullable|string|max:1000',
        ]);

        $data = $request->except(['_token']);
        $data['photo'] = null;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Profile::create($data); 

        return redirect()->route('profile.show')->with('success', 'Profile created successfully.');
    }

    public function show()
    {
        $profile = Profile::firstOrFail(); // Ensures one profile exists
        $profile->load(['education', 'comments']); 
        return view('profiles.show', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::firstOrFail(); // Get the existing profile


        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'photo' => 'nullable|image|max:2048', 
            'hobbies' => 'nullable|string|max:1000',
        ]);
        
        $data = $request->only(['name', 'gender', 'hobbies']);
        

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            // Store new photo
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }


        $profile->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }


    public function destroy()
    {
        $profile = Profile::firstOrFail();
        
        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
        }

        $profile->delete();

        // Redirect to create page after deletion
        return redirect()->route('profile.create')->with('success', 'Profile deleted successfully.');
    }
    
}