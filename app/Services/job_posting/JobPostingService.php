<?php
namespace App\Services\job_posting;

use App\Models\JobPosting;
use App\Services\GenericService;

class JobPostingService extends GenericService implements IJobPostingService {
    public function __construct() {
        parent::__construct(JobPosting::class);
    }

    function getByIdWithRelation($jobPostingId) {
        return $this->model::with([
            'position' => function($query) {
                $query->with('salary')->with('office')->with('company');
            }
        ])->with('adtype')->with('banner')->with('sample_photos')->find($jobPostingId);
    }

    function getByCompanyId($company_id) {
        return $this->model::with([
            'position' => function($query) {
                $query->with('salary');
            }
        ])->with('adtype')->with('banner')->with('sample_photos')->whereHas('position', function($query) use($company_id) {
            $query->where('company_id', $company_id);
        })->get();
    }

    function getSampleFeaturedJobPosting() {
        return $this->model::with([
            'position' => function($query) {
                $query->with('salary')->with('office');
            }
        ])->with('adtype')->with('banner')->with('sample_photos')->where('is_hidden', false)->whereHas('adtype', function($query) {
            $query->where('is_featured', true);
        })->where('paid', true)->inRandomOrder()->take(4)->get();
    }
}
