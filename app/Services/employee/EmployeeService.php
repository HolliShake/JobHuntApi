<?php
namespace App\Services\employee;

use App\Services\employee\IEmployeeService;
use App\Services\GenericService;

class Employee extends GenericService implements IEmployeeService
{
    public function __construct() {
        parent::__construct(App\Models\Employee::class);
    }

    public function getEmployeeByUserId($userId) {

    }
}
