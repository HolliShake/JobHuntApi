<?php
namespace App\Services\company;

use App\Services\GenericService;

class CompanyService extends GenericService implements ICompanyService {
    public function __construct() {
        parent::__construct(Company::class);
    }
}
