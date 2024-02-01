<?php
namespace App\Http\Controllers;

use App\Services\salary\ISalaryService;
use Illuminate\Support\Facades\Validator;

class SalaryController extends ControllerBase
{
    function __construct(protected readonly ISalaryService $salaryService){
    }

    function getAllSalaries() {
        return $this->ok($this->salaryService->all());
    }

    function getSalariesByCompanyId($company_id) {
        return $this->ok($this->salaryService->getSalaryByCompanyId($company_id));
    }

    function getSalaryById($salary_id) {
        $salary = $this->salaryService->getById($salary_id);
        return ($salary)
            ? $this->ok($salary)
            : $this->notFound('');
    }

    function createSalary() {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $salary = $this->salaryService->create(request()->all());
        return ($salary)
            ? $this->created($salary)
            : $this->badRequest('');
    }

    function updateSalary($salary_id) {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $old = $this->salaryService->getById($salary_id);
        if (!$old) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $old, request()->all());
        $uresult = $this->salaryService->update($updated);
        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest('');
    }

    function deleteSalary($salary_id) {
        $salary = $this->salaryService->getById($salary_id);
        if (!$salary) {
            return $this->notFound('');
        }

        $success = $this->salaryService->delete($salary);

        return ($success)
            ? $this->noContent()
            : $this->badRequest('');
    }

    function rules() {
        return [
            'title' => 'required|string',
            'level' => 'required|string',
            'value' => 'required|numeric',
            'currency' => 'required|string',
            // 'company_id' => 'required|integer',
        ];
    }
}
