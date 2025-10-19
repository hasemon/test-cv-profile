<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Profile;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'degree' => 'required',
            'institute' => 'required',
            'session' => 'required',
            'ending' => 'required',
        ]);

        $profile = Profile::first();
        $profile->educations()->create($request->all());

        return back();
    }

    public function destroy($id)
    {
        Education::findOrFail($id)->delete();
        return back();
    }
}
