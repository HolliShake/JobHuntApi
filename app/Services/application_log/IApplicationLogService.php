<?php
namespace App\Services\application_log;

use App\Services\IGenericService;

interface IApplicationLogService extends IGenericService {
    function getDashboardApplicationLogsByCompanyId($company_id);
}
