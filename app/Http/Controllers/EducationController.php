<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'degree'=>'required',
            'institute'=>'required',
            'start_date'=>'required|date',
            'end_year'=>'required|digits:4'
        ]);
        $profile->educations()->create($data);
        return back();
    }

    public function edit(Education $education)
    {
        return view('educations.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $data = $request->validate([
            'degree'=>'required',
            'institute'=>'required',
            'start_date'=>'required|date',
            'end_year'=>'required|digits:4'
        ]);
        $education->update($data);
        return redirect()->route('profiles.show', $education->profile_id);
    }
}
