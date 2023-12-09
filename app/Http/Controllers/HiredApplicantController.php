<?php

namespace App\Http\Controllers;

use App\Services\hired_applicant\IHiredApplicantService;
use Illuminate\Http\Request;

class HiredApplicantController extends ControllerBase
{
    function __construct(protected IHiredApplicantService $hiredApplicantService)
    {
    }

    function getEmployeeByCompanyId($company_id) {
        return $this->ok($this->hiredApplicantService->getHiredApplicantByCompanyId($company_id));
    }

    function deleteHiredApplicant($hired_applicant_id) {
        $result = $this->hiredApplicantService->getById($hired_applicant_id);

        if (!$result) {
            return $this->notFound('');
        }

        $deleted = $this->hiredApplicantService->delete($result);

        return ($deleted)
            ? $this->noContent()
            : $this->badRequest("");
    }
}
