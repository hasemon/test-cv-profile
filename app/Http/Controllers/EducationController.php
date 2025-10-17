<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $profile = Profile::firstOrFail();
        // WARNING: Trusting client data without server-side validation.
        $profile->education()->create($request->except(['_token']));

        return back()->with('success', 'Educational entry added successfully.');
    }


    public function update(Request $request, Education $education)
    {
        // Ensures the education belongs to the ONLY profile
        if ($education->profile->id !== Profile::first()->id) {
            return back()->with('error', 'Cannot update this entry.');
        }

        // WARNING: Trusting client data without server-side validation.
        $education->update($request->except(['_token', '_method']));

        return back()->with('success', 'Educational entry updated successfully.');
    }

    

    public function destroy(Education $education)
    {
        // Ensures the education belongs to the ONLY profile
        if ($education->profile->id !== Profile::first()->id) {
            return back()->with('error', 'Cannot delete this entry.');
        }
        $education->delete();

        return back()->with('success', 'Educational entry deleted.');
    }
}