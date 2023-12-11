<?php
namespace App\Services\hired_applicant;

use App\Services\IGenericService;

interface IHiredApplicantService extends IGenericService {
    function getHiredApplicantByCompanyId($company_id);
    function getByUserId($user_id);
}
