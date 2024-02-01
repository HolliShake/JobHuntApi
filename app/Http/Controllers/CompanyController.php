<?php

namespace App\Http\Controllers;

use App\Services\company\ICompanyService;
use App\Services\office\IOfficeService;
use Illuminate\Support\Facades\Validator;

class CompanyController extends ControllerBase
{
    function __construct(
        protected readonly ICompanyService $companyService,
        protected readonly IOfficeService $officeService,
    )
    {
    }

    function all()
    {
        return $this->ok($this->companyService->all());
    }

    function getCompanyById($company_id)
    {
        $company = $this->companyService->getById($company_id);

        return ($company)
            ? $this->ok($company)
            : $this->notFound("Company not found.");
    }

    function myCompany()
    {
        $company = $this->companyService->getAllCompaniesByUserId(auth()->user()->id);

        return ($company)
            ? $this->ok($company)
            : $this->notFound("Company not found.");
    }

    function getDefaultCompany()
    {
        $company = $this->companyService->getDefaultCompany();

        return ($company)
            ? $this->ok($company)
            : $this->notFound("Company not found.");
    }

    function allPartners()
    {
        return $this->ok($this->companyService->allPartners());
    }

    function createCompany()
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $company = $this->companyService->create(request()->all());
        if ($company)
        {
            $office_result = $this->officeService->create([
                'company_id' => $company->id,
                'name' => $company->company_name . ' ' . 'Main Office',
                'address' => $company->address,
                'mobile_number' => '09123456789',
                'country' => 'Philippines',
            ]);

            if (!$office_result)
            {
                return $this->badRequest("Something went wrong while creating.");
            }
        }

        return ($company)
            ? $this->created($company)
            : $this->badRequest("Something went wrong while creating.");
    }

    function acceptCompany($company_id) {
        $company = $this->companyService->getById($company_id);

        if (!$company)
        {
            return $this->notFound("");
        }

        $updated = (object) array_merge((array) $company, [
            'id' => $company_id,
            'verified_by_admin' => true,
            'is_declined' => false,
        ]);
        $uresult = $this->companyService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest("Something went wrong while updating.");
    }

    function rejectCompany($company_id) {
        $company = $this->companyService->getById($company_id);

        if (!$company)
        {
            return $this->notFound("");
        }

        $updated = (object) array_merge((array) $company, [
            'id' => $company_id,
            'verified_by_admin' => true,
            'is_declined' => true,
        ]);
        $uresult = $this->companyService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest("Something went wrong while updating.");
    }

    function updateCompany($company_id)
    {
        $validator = Validator::make(request()->all(), $this->updateRules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $company = $this->companyService->getById($company_id);

        if (!$company)
        {
            return $this->notFound("");
        }

        $updated = (object) array_merge((array) $company, request()->all());
        $uresult = $this->companyService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest("Something went wrong while updating.");
    }

    function deleteCompany($company_id)
    {
        $company = $this->companyService->getById($company_id);

        if (!$company)
        {
            return $this->notFound("");
        }

        $success = $this->companyService->delete($company);

        return ($success)
            ? $this->noContent()
            : $this->badRequest("Something went wrong while deleting.");
    }

    function updateRules()
    {
        return [
            'company_name' => 'required|string|max:75',
            'email' => 'required|email|string',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|string',
            'user_id' => 'required',
        ];
    }

    function rules()
    {
        return [
            'company_name' => 'required|string|max:75|unique:company,company_name',
            'email' => 'required|email|string',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|string',
            'user_id' => 'required',
        ];
    }

    //
    function publicAllCompany() {
        return $this->ok($this->companyService->publicAll());
    }

    function getSampleCompanies() {
        return $this->ok($this->companyService->getSampleCompanies());
    }
}
