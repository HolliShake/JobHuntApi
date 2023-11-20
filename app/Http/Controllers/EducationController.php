<?php

namespace App\Http\Controllers;

use App\Services\education\IEducationService;
use App\Services\personal_data\IPersonalDataService;
use App\Services\user\IUserService;
use Illuminate\Support\Facades\Validator;

class EducationController extends ControllerBase
{
    function __construct(
        protected readonly IUserService $userService,
        protected readonly IPersonalDataService $personalDataService,
        protected readonly IEducationService $educationService
    ) {

    }

    function all() {
        return $this->ok($this->educationService->all());
    }

    function getEducationsByUserId($user_id) {
        return $this->ok($this->educationService->getEducationsByUserId($user_id));
    }

    function getEducationsByLoggedInUser() {
        $user = request()->user();
        return $this->ok($this->educationService->getEducationsByUserId($user->id));
    }

    function createEducation()
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $user = $this->userService->getUserWithPersonalData(request()->input('user_id'));

        if (!($user->personal_data)) {
            // Create Personal Data
            $pd = $this->personalDataService->makeDefault(request()->input('user_id'));

            if (!$pd) {
                return $this->badRequest("");
            } else {
                $result = $this->educationService->create([
                    ...request()->all(),
                    //
                    'personal_data_id' => $pd->id,
                ]);

                return ($result)
                    ? $this->created($result)
                    : $this->badRequest("");
            }

        } else {
            $result = $this->educationService->create([
                ...request()->all(),
                'personal_data_id' => $user->personal_data->id,
            ]);

            return ($result)
                ? $this->created($result)
                : $this->badRequest("");
        }
    }
}


/*
    Route::get('/Education/all', 'all');
    Route::get('/Education/User/{user_id}', 'getEducationsByUserId')->where('user_id', '\d*');
    Route::middleware('auth:api')->get('/Education/My', 'getEducationsByLoggedInUser');
    Route::post('/Education/create', 'createEducation');
    Route::put('/Education/update/{education_id}', 'updateEducation')->where('education_id', '\d*');
    Route::delete('/Education/delete/{education_id}', 'deleteEducation')->where('education_id', '\d*');
*/
