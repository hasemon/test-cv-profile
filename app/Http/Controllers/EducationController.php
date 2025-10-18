<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Profile;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        $validated['profile_id'] = $profile->id;

        Education::create($validated);

        return back()->with('success', 'Education added successfully.');
    }

    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        $education->update($validated);

        return back()->with('success', 'Education updated successfully.');
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return back()->with('success', 'Education deleted successfully.');
    }
}
