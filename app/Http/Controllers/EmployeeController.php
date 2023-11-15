<?php

namespace App\Http\Controllers;

use App\Services\employee\IEmployeeService;

class EmployeeController extends ControllerBase
{
    function __construct(private readonly IEmployeeService $employeeService)
    {
    }

    function createEmployee()
    {

    }

    function rules()
    {
        return [
            'employeeID' => 'required',
            'email' => 'required|email',
        ];
    }
}

/*
    $table->string('employeeID');
    // Add more fields later
    // Fk
    $table->unsignedBigInteger('hired_applicant_id');
    $table->foreign('hired_applicant_id')->references('id')->on('hired_applicant');
*/
