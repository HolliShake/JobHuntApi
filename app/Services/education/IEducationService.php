<?php

namespace App\Services\education;

use App\Services\IGenericService;

interface IEducationService extends IGenericService {
    function getEducationsByUserId($user_id);
}
