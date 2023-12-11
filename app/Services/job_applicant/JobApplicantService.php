<?php
namespace App\Services\job_applicant;

use App\Models\JobApplicant;
use App\Services\GenericService;

class JobApplicantService extends GenericService implements IJobApplicantService
{
    public function __construct() {
        parent::__construct(JobApplicant::class);
    }

    function getById($id)
    {
        return $this->model::with([
            'user' => function($query) {
                $query->with([
                    'personal_data' => function($pquery) {
                        $pquery->with('education')->with('skill');
                    }
                ])->with('profile_image')->with('cover_image');
            }
        ])
        ->with([
            'job_posting' => function($query) {
                $query->with([
                    'position' => function($pquery) {
                        $pquery->with('office')->with('salary')->with('company');
                    }
                ])->with('banner')->with('sample_photos');
            }
         ])
        ->with('application_logs')
        ->find($id);
    }

    function getJobApplicationByUserId($user_id) {
        return $this->model::with([
            'user' => function($query) {
                $query->with([
                    'personal_data' => function($pquery) {
                        $pquery->with('education')->with('skill');
                    }
                ])->with('profile_image')->with('cover_image');
            }
        ])
        ->with([
            'job_posting' => function($query) {
                $query->with('position');
            }
         ])
        ->where('user_id', $user_id)->get();
    }

    function getJobApplicationByJobPostingId($job_posting_id) {
        return $this->model::with([
            'user' => function($query) {
                $query->with([
                    'personal_data' => function($pquery) {
                        $pquery->with('education')->with('skill');
                    }
                ])->with('profile_image')->with('cover_image');
            }
        ])
        ->with([
            'job_posting' => function($query) {
                $query->with('position');
            }
         ])
        ->where('job_posting_id', $job_posting_id)->get();
    }

    function getJobApplicationByCompanyId($company_id) {
        return $this->model::with([
            'user' => function($query) {
                $query->with([
                    'personal_data' => function($pquery) {
                        $pquery->with('education')->with('skill');
                    }
                ])->with('profile_image')->with('cover_image');
            }
        ])
        ->with([
            'job_posting' => function($query) {
                $query->with('position');
            }
         ])
        ->whereHas('job_posting', function($query) use ($company_id) {
            $query->whereHas('position', function($query) use ($company_id) {
                $query->where('company_id', $company_id);
            });
        })->where('status', 'pending')->get();
    }
}
