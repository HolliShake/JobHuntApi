<?php

namespace App\Services\education;

use App\Models\Education;
use App\Services\GenericService;

class EducationService extends GenericService implements IEducationService
{
    function __construct()
    {
        parent::__construct(Education::class);
    }

    function getEducationsByUserId($userId)
    {
        return $this->model::with('personal_data')->whereHas('personal_data', function($query) use($userId) {
            $query->where('user_id', $userId);
        })->get();
    }
}
