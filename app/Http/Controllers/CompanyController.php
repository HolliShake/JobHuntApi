<?php

namespace App\Http\Controllers;

use App\Services\company\ICompanyService;
use Illuminate\Support\Facades\Validator;

class CompanyController extends ControllerBase
{
    function __construct(protected readonly ICompanyService $companyService) {
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
        $company = $this->companyService->getById(auth()->user()->id);

        return ($company)
            ? $this->ok($company)
            : $this->notFound("Company not found.");
    }

    function createCompany()
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $company = $this->companyService->create(request()->all());

        return ($company)
            ? $this->created($company)
            : $this->badRequest("Something went wrong while creating.");
    }

    function updateCompany($company_id)
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest($validator->errors());
        }

        $company = $this->companyService->getById($company_id);

        if (!$company)
        {
            return $this->notFound("");
        }

        $updated = array_merge($company, request()->all());
        $updated = $this->companyService->update($updated);

        return ($updated)
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
}
