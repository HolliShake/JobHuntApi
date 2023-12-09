<?php

namespace App\Http\Controllers;

use App\Services\file_cover\IFileCoverService;
use Illuminate\Support\Facades\Validator;

class FileCoverController extends ControllerBase
{
    function __construct(protected IFileCoverService $fileCoverService) {
    }


    function changeCover() {
        $validator = Validator::make(request()->all(), [
            'user_id' => 'required|integer',
            'cover' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $cover = request()->file('cover');
        $profile_file_name = time() . '_' . $cover->getClientOriginalName();
        $bresult = $cover->storeAs('uploads', $profile_file_name, 'public');

        $bannerResult = null;

        if ($bresult) {
            $this->fileCoverService->deleteByUserId(request()->input('user_id'));
            $bannerResult = $this->fileCoverService->create([
                'user_id' => request()->input('user_id'),
                'file_name' => $profile_file_name,
            ]);

            if (!$bannerResult) {
                return $this->badRequest('');
            }
        }

        return $this->ok($bannerResult);
    }
}
