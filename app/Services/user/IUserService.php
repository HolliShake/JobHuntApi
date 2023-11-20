<?php

namespace App\Services\user;

use App\Services\IGenericService;

interface IUserService extends IGenericService {
    function getByEmail($email);
    function getUserWithPersonalData($userId);
}
