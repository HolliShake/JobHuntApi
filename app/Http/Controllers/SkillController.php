<?php

namespace App\Http\Controllers;

use App\Services\personal_data\IPersonalDataService;
use App\Services\skill\ISkillService;
use App\Services\user\IUserService;
use Illuminate\Support\Facades\Validator;


class SkillController extends ControllerBase
{
    function __construct(
        protected readonly ISkillService $skillService,
        protected readonly IUserService $userService,
        protected readonly IPersonalDataService $personalDataService,
    ) {
    }

    function all()
    {
        return response()->json($this->skillService->all(), 200);
    }

    function getSkillsByUserId($user_id)
    {
        return $this->ok($this->skillService->getSkillsByUserId($user_id));
    }

    function getSkillsByLoggedInUser()
    {
        $user = request()->user();
        return $this->ok($this->skillService->getSkillsByUserId($user->id));
    }

    function createSkill()
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
                $result = $this->skillService->create([
                    ...request()->all(),
                    //
                    'personal_data_id' => $pd->id,
                ]);

                return ($result)
                    ? $this->created($result)
                    : $this->badRequest("");
            }

        } else {
            $result = $this->skillService->create([
                ...request()->all(),
                'personal_data_id' => $user->personal_data->id,
            ]);

            return ($result)
                ? $this->created($result)
                : $this->badRequest("");
        }
    }

    function updateSkill($skill_id)
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $result = $this->skillService->getById($skill_id);

        if (!$result) {
            return $this->notFound('');
        }


        $updated = (object) array_merge((array) $result, request()->all());
        $uresult = $this->skillService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest("");
    }

    function deleteSkill($skill_id)
    {
        $result = $this->skillService->getById($skill_id);

        if (!$result) {
            return $this->notFound('');
        }

        $deleted = $this->skillService->delete($result);

        return ($deleted)
            ? $this->noContent()
            : $this->badRequest("");
    }

    function rules()
    {
        return [
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:2048',
            'progress' => 'required|integer',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
