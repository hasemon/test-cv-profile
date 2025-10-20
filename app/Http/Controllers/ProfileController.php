<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
<<<<<<< HEAD

    public function create()
    {
        $profile = Profile::first();

        return view('profiles.create', compact('profile'));
=======
    // Redirects if a profile already exists
    public function create()
    {
        $profile = Profile::first();
        // if ($profile) 
        {
         return view('profiles.create', compact('profile'));
        // 
        }

        // return view('profiles.create');
>>>>>>> cf437bc1f4c68d744750a593d3c29000e462ba05
    }

    public function store(Request $request)
    {
<<<<<<< HEAD

=======
        // Check for existing profile (shouldn't happen if routed correctly)
>>>>>>> cf437bc1f4c68d744750a593d3c29000e462ba05
        if (Profile::exists()) {
            return redirect()->route('profile.show')->with('error', 'A profile already exists.');
        }

<<<<<<< HEAD

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'hobbies' => 'nullable|string|max:1000',
        ]);

=======
>>>>>>> cf437bc1f4c68d744750a593d3c29000e462ba05
        $data = $request->except(['_token']);
        $data['photo'] = null;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

<<<<<<< HEAD
        Profile::create($data); 
=======
        Profile::create($data); // WARNING: Unsecured Mass Assignment
>>>>>>> cf437bc1f4c68d744750a593d3c29000e462ba05

        return redirect()->route('profile.show')->with('success', 'Profile created successfully.');
    }

    public function show()
    {
        $profile = Profile::firstOrFail(); // Ensures one profile exists
        $profile->load(['education', 'comments']); 
        return view('profiles.show', compact('profile'));
    }
<<<<<<< HEAD

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
=======
    
    // We'll use the 'create' view for update as well, so no separate edit needed
    // The 'show' view contains the update form structure.

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'degree' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'start_date' => 'required|string|max:50',
            'end_year' => 'required|string|max:10',
        ]);

        if ($education->profile->id !== Profile::first()->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $education->update($request->except(['_token', '_method']));

        return back()->with('success', 'Educational entry updated successfully.');
>>>>>>> cf437bc1f4c68d744750a593d3c29000e462ba05
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
<<<<<<< HEAD
    
=======
>>>>>>> cf437bc1f4c68d744750a593d3c29000e462ba05
}