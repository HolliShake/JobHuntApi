<?php
namespace App\Services\company;

use App\Models\Company;
use App\Services\GenericService;

use function Laravel\Prompts\select;

class CompanyService extends GenericService implements ICompanyService {
    public function __construct() {
        parent::__construct(Company::class);
    }

    function allPartners() {
        return $this->model::with('employeeStatus')->where('is_default', false)->get();
    }

    function getAllCompaniesByUserId($user_id) {
        return $this->model::where('user_id', $user_id)->get();
    }

    function publicAll()
    {
        return $this->model::
            with('user')
            ->with('rating')
            ->where('status', 'active')->inRandomOrder()->get()->append('average');
    }

    function getSampleCompanies() {
        return $this->model::with([
            'user' => function($query) {
                // $query->with('profile_pic');
            }
        ])->where('status', 'active')->inRandomOrder()->take(10)->get();
    }

    function getDefaultCompany() {
        return $this->model::with([
            'user' => function($query) {
                // $query->with('profile_pic');
            }
        ])->where('is_default', true)->first();
    }
}
