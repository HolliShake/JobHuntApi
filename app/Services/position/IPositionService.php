<?php
namespace App\Services\position;

use App\Services\IGenericService;

interface IPositionService extends IGenericService {
    function getPositionsByCompanyId($company_id);
}
