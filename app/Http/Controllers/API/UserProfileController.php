<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\UserInfo;
use App\Service\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * @param ProfileService $profileService
     * @return JsonResponse
     */
    public function index(ProfileService $profileService): JsonResponse
    {
        $profile = $profileService->fetchProfile();

        if ($profile) {
            return $this->successJsonResponse("Profile Found", $profile);
        }

        return $this->errorJsonResponse("Profile Not Found");
    }

    public function store(ProfileRequest $request, ProfileService  $profileService): JsonResponse
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $oldImage = null;
            if (!empty($validated['id'])) {
                $userInfo = UserInfo::where('id', $validated['id'])->first();
                if ($userInfo) {
                    $oldImage = $userInfo->image;
                }

            }
            $validated['image'] = $profileService->uploadImage($request, $oldImage);
        }

        if (!empty($validated['education'])) {
            $validated['education_information'] = $validated['education'];
            unset($validated['education']);
        }

        try{
            if (empty($validated['id']) && !UserInfo::create($validated)) {
                return $this->errorJsonResponse("Failed to create profile");
            }

            if (!empty($validated['id']) && !UserInfo::where('id', $validated['id'])->update($validated)) {
                return $this->errorJsonResponse("Failed to update profile");
            }

            return $this->successJsonResponse(empty($validated['id'])? "Profile Created" : "Profile Updated");
        } catch (\Throwable $th) {
            return $this->errorJsonResponse($th);
        }
    }
}
