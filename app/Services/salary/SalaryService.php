<?php
namespace App\Services\salary;

use App\Models\Salary;
use App\Services\GenericService;

class SalaryService extends GenericService implements ISalaryService
{
    function __construct()
    {
        parent::__construct(Salary::class);
    }

    function getSalaryByCompanyId($companyId)
    {
        return $this->model::where('company_id', $companyId)->orderByRaw('CHAR_LENGTH(title)')->orderBy('title', 'asc')->get();
    }
}

