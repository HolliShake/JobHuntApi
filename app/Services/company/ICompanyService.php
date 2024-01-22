<?php
namespace App\Services\company;

use App\Services\IGenericService;

interface ICompanyService extends IGenericService {
    function getAllCompaniesByUserId($user_id);
    function publicAll();
    function getSampleCompanies();
    function getDefaultCompany();
    function allPartners();
}
