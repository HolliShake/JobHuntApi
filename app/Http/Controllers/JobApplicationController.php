<?php

namespace App\Http\Controllers;

use App\Services\job_applicant\IJobApplicantService;

class JobApplicationController extends ControllerBase
{
    function __construct(protected IJobApplicantService $jobApplicantService) {
    }

    function getJobApplicationById($job_application_id) {
        $data = $this->jobApplicantService->getById($job_application_id);
        return ($data)
            ? $this->ok($data)
            : $this->notFound('');
    }

    //
    function applyJobPost($job_posting_id) {
        $user = request()->user();

        return ($this->jobApplicantService->create([ 'job_posting_id' => $job_posting_id, 'user_id' => $user->id ]))
            ? $this->noContent()
            : $this->badRequest('');
    }

    function getJobApplicationByJobPostingId($job_posting_id) {
        return $this->ok($this->jobApplicantService->getJobApplicationByJobPostingId($job_posting_id));
    }

    function myApplication() {
        $user = request()->user();
        return $this->ok($this->jobApplicantService->getJobApplicationByUserId($user->id));
    }
}
