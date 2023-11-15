<?php

namespace App\Services\skill;

use App\Models\Skill;
use App\Services\GenericService;

class SkillService extends GenericService implements ISkillService {
    public function __construct() {
        parent::__construct(Skill::class);
    }
}

