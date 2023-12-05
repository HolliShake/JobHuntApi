<?php
namespace App\Services\job_applicant;

use App\Services\IGenericService;

interface IJobApplicantService extends IGenericService {
    function getJobApplicationByUserId($user_id);
    function getJobApplicationByJobPostingId($job_posting_id);
}
