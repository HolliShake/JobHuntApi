<?php
namespace App\Services\company;

use App\Services\IGenericService;

interface ICompanyService extends IGenericService {
    function getAllCompaniesByUserId($user_id);
}
