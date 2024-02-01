<?php
namespace App\Services\job_posting;

use App\Services\IGenericService;

interface IJobPostingService extends IGenericService {
    function getByIdWithRelation($jobPostingId);
    function getByCompanyId($company_id);
    function getAllApprovedByCompanyId($company_id);
    function getSampleFeaturedJobPosting();
    function publicAllJobPosting();
}
