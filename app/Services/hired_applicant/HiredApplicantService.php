<?php
namespace App\Services\hired_applicant;

use App\Models\HiredApplicant;
use App\Services\GenericService;

class HiredApplicantService extends GenericService implements IHiredApplicantService {
    public function __construct() {
        parent::__construct(HiredApplicant::class);
    }

    function getHiredApplicantByCompanyId($company_id) {
        return $this->model::with([
            'job_applicant' => function($query) {
                $query->with([
                    'job_posting' => function($pquery) {
                        $pquery->with([
                            'position' => function($squery) {
                                $squery->with('salary');
                            }
                        ]);
                    }
                ])
                ->with([
                    'user' => function($query) {
                        $query->with('profile_image')->with('cover_image');
                    }
                ]);
            }
         ])
         ->whereHas('job_applicant',  function($query) use ($company_id) {
            $query->whereHas('job_posting', function($pquery) use ($company_id) {
                $pquery->whereHas('position', function($cquery) use ($company_id) {
                    $cquery->where('company_id', $company_id);
                });
            })->groupBy('user_id');
         })->get();
    }

    function getByUserId($user_id) {
        return $this->model::with([
            'job_applicant' => function($query) {
                $query->with([
                    'job_posting' => function($pquery) {
                        $pquery->with([
                            'position' => function($squery) {
                                $squery->with('salary')->with('company')->with('office');
                            }
                        ]);
                    }
                ])
                ->with([
                    'user' => function($query) {
                        $query->with('profile_image')->with('cover_image');
                    }
                ]);
            }
        ])
        ->whereHas('job_applicant', function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
    }
}
