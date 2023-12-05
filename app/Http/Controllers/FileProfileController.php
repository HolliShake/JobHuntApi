<?php
namespace App\Http\Controllers;

use App\Services\file_profile\IFileProfileService;
use Illuminate\Support\Facades\Validator;

class FileProfileController extends ControllerBase {
    function __construct(protected IFileProfileService $fileProfileService) {
    }

    function changeDp() {
        $validator = Validator::make(request()->all(), [
            'user_id' => 'required|integer',
            'profile' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $profile = request()->file('profile');
        $profile_file_name = time() . '_' . $profile->getClientOriginalName();
        $bresult = $profile->storeAs('uploads', $profile_file_name, 'public');

        $bannerResult = null;

        if ($bresult) {
            $this->fileProfileService->deleteByUserId(request()->input('user_id'));
            $bannerResult = $this->fileProfileService->create([
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
