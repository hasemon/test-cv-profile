<?php

namespace App\Service;


use App\Models\UserInfo;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * @return array
     */
    public function fetchProfile(): array
    {
        $profile = UserInfo::select('id', 'name', 'image', 'gender', 'hobbies', 'education_information AS education')->first();
        return $profile ? $profile->toArray() : [];
    }

    /**
     * @param $request
     * @param null $oldImage
     * @return mixed|null
     */
    public function uploadImage($request, $oldImage = null)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            return $image->storeAs('profiles', $filename, 'public');
        }

        return $oldImage;
    }
}
