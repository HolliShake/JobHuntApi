<?php
namespace App\Http\Controllers;

use App\Services\hired_applicant\IHiredApplicantService;
use App\Services\job_applicant\IJobApplicantService;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends ControllerBase
{
    function __construct(
        protected IJobApplicantService $jobApplicantService,
        protected IHiredApplicantService $hiredApplicantService
    )
    {
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

        $result = $this->jobApplicantService->create([ 'job_posting_id' => $job_posting_id, 'user_id' => $user->id ]);

        return ($result)
            ? $this->created($result)
            : $this->badRequest('');
    }

    function getJobApplicationByJobPostingId($job_posting_id) {
        return $this->ok($this->jobApplicantService->getJobApplicationByJobPostingId($job_posting_id));
    }

    function getDashboardJobApplicationByCompanyId($company_id) {
        return $this->ok($this->jobApplicantService->getJobApplicationByCompanyId($company_id));
    }

    function myApplication() {
        $user = request()->user();
        return $this->ok($this->jobApplicantService->getJobApplicationByUserId($user->id));
    }

    function myPendingApplicationByJobPosting($job_posting_id) {
        $user = request()->user();
        return $this->ok($this->jobApplicantService->getPendingJobApplicationByUserAndJobPostId($user->id, $job_posting_id));
    }

    //
    function approveJobApplication($job_application_id) {
        $validator = Validator::make(request()->all(), [
            'status' => 'required|in:accepted,rejected'
        ]);

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $data = $this->jobApplicantService->getById($job_application_id);

        if (!$data) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $data, [
            'id' => request()->input('id'),
            'status' => 'accepted'
        ]);
        $uresult = $this->jobApplicantService->update($updated);

        if ($uresult && strcmp(request()->input('status'), 'accepted') === 0) {
            $hired_applicant = $this->hiredApplicantService->create([
                'job_applicant_id' => $job_application_id
            ]);

            if ($hired_applicant) {
                return $this->noContent();
            }
        } else {
            return $this->badRequest('');
        }
    }

    function rejectJobApplication($job_application_id) {
        $validator = Validator::make(request()->all(), [
            'status' => 'required|in:accepted,rejected'
        ]);

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $data = $this->jobApplicantService->getById($job_application_id);

        if (!$data) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $data, request()->all());
        $uresult = $this->jobApplicantService->update($updated);

        return ($uresult)
            ? $this->noContent()
            : $this->badRequest('');
    }

    function deleteJobApplication($job_application_id) {
        $data = $this->jobApplicantService->getById($job_application_id);

        if (!$data) {
            return $this->notFound('');
        }

        if (strcmp($data->status, 'pending') !== 0) {
            return $this->badRequest([ 'errors' => 'application is not pending!' ]);
        }

        return ($this->jobApplicantService->delete($data))
            ? $this->noContent()
            : $this->badRequest('');
    }
}
