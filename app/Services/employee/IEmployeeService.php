<?php

namespace App\Services\employee;

use App\Services\IGenericService;

interface IEmployeeService extends IGenericService
{
    public function getEmployeeByUserId($userId);
}
