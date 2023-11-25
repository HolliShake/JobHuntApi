<?php
namespace App\Services\office;

use App\Services\IGenericService;

interface IOfficeService extends IGenericService {
    function getOfficesByCompanyId($company_id);
}
