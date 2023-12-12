<?php
namespace App\Services\job_applicant;

use App\Services\IGenericService;

interface IJobApplicantService extends IGenericService {
    function getJobApplicationByUserId($user_id);
    function getJobApplicationByJobPostingId($job_posting_id);
    function getJobApplicationByCompanyId($company_id);
    function getPendingJobApplicationByUserAndJobPostId($user_id, $job_posting_id);
}
