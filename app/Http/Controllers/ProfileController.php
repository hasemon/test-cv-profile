<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
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
    }

    public function store(Request $request)
    {
        // Check for existing profile (shouldn't happen if routed correctly)
        if (Profile::exists()) {
            return redirect()->route('profile.show')->with('error', 'A profile already exists.');
        }

        $data = $request->except(['_token']);
        $data['photo'] = null;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Profile::create($data); // WARNING: Unsecured Mass Assignment

        return redirect()->route('profile.show')->with('success', 'Profile created successfully.');
    }

    public function show()
    {
        $profile = Profile::firstOrFail(); // Ensures one profile exists
        $profile->load(['education', 'comments']); 
        return view('profiles.show', compact('profile'));
    }
    
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