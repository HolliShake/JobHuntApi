<?php

namespace App\Services\salary;

use App\Services\IGenericService;

interface ISalaryService extends IGenericService {
    function getSalaryByCompanyId($companyId);
}
