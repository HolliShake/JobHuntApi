<?php

namespace App\Http\Controllers;

use App\Services\employee\IEmployeeService;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends ControllerBase
{
    function __construct(private readonly IEmployeeService $employeeService)
    {
    }

    function createEmployee()
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }
    }

    function rules()
    {
        return [
            'employeeID' => 'required|string',
            'hired_applicant_id' => 'required',
        ];
    }
}
