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

    function updateEducation($education_id)
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $result = $this->educationService->getById($education_id);

        if (!$result) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $result, request()->all());
        $uresult = $this->educationService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest("");
    }

    function rules()
    {
        return [
            'school_name' => 'required|string|max:100',
            'location' => 'required|string',
            'status' => 'required|string',
            'start_sy' => 'required|date',
            'end_sy' => 'required|date',
            'user_id' => 'required|integer'
        ];
    }
}

