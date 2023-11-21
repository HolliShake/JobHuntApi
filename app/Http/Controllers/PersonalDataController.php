<?php

namespace App\Http\Controllers;

use App\Services\personal_data\IPersonalDataService;
use Illuminate\Http\Request;

class PersonalDataController extends ControllerBase
{
    function __construct(protected readonly IPersonalDataService $personalDataService) {
    }

    function all() {
        return $this->ok($this->personalDataService->all());
    }

    function getPersonalDataByLoggedInUser() {
        $user = request()->user();
        $data = $this->personalDataService->getPersonalDataByUserId($user->id);

        if (!$data) {
            $data = $this->personalDataService->makeDefault($user->id);
        }

        return ($data)
            ? $this->ok($data)
            : $this->notFound('');
    }

    function getPersonalDataByUserId($user_id) {
        $data = $this->personalDataService->getPersonalDataByUserId($user_id);
        return ($data)
            ? $this->ok($data)
            : $this->notFound('');
    }

    function updatePersonalData($personal_data_id) {
        $data = $this->personalDataService->getById($personal_data_id);

        if (!$data) {
            return $this->notFound('');
        }

        $newData = (object) array_merge(
            (array) $data,
            request()->all()
        );

        $result = $this->personalDataService->update($newData);
        return ($result)
            ? $this->ok($result)
            : $this->badRequest('');
    }
}
