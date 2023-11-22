<?php
namespace App\Services\company;

use App\Models\Company;
use App\Services\GenericService;

class CompanyService extends GenericService implements ICompanyService {
    public function __construct() {
        parent::__construct(Company::class);
    }

    function getAllCompaniesByUserId($user_id) {
        return $this->model::where('user_id', $user_id)->get();
    }
}
