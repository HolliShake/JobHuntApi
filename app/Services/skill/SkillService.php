<?php

namespace App\Services\skill;

use App\Models\Skill;
use App\Services\GenericService;

class SkillService extends GenericService implements ISkillService {
    public function __construct() {
        parent::__construct(Skill::class);
    }

    function getSkillsByUserId($userId) {
        return $this->model::with('personal_data')->whereHas('personal_data', function($query) use($userId) {
            $query->where('user_id', $userId);
        })->get();
    }
}

