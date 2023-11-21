<?php

namespace App\Services\personal_data;

use App\Models\PersonalData;
use App\Services\GenericService;

class PersonalDataService extends GenericService implements IPersonalDataService {
    public function __construct() {
        parent::__construct(PersonalData::class);
    }

    function makeDefault($userId) {
        if ($this->getPersonalDataByUserId($userId)) {
            return null;
        }

        return $this->create([
            'address' => '',
            'postal' => 0,
            'municipality' => '',
            'city' => '',
            'religion' => '',
            'civil_status' => '',
            'citizenship' => '',
            //
            'mother_first_name' => '',
            'mother_maiden_name' => '',
            'mother_last_name' => '',
            //
            'father_first_name' => '',
            'father_middle_name' => '',
            'father_last_name' => '',
            //
            'user_id' => $userId,
        ]);
    }

    function getPersonalDataByUserId($userId) {
        return $this->model::where('user_id', $userId)->first();
    }
}
