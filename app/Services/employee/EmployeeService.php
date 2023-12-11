<?php
namespace App\Services\employee;

use App\Services\employee\IEmployeeService;
use App\Services\GenericService;
use App\Models\Employee;

class EmployeeService extends GenericService implements IEmployeeService
{
    public function __construct() {
        parent::__construct(Employee::class);
    }

    public function getEmployeeByUserId($userId) {

    }
}
