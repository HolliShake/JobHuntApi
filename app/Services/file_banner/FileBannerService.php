<?php
namespace App\Services\file_banner;

use App\Models\FileBanner;
use App\Services\GenericService;

class FileBannerService extends GenericService implements IFileBannerService
{
    public function __construct() {
        parent::__construct(FileBanner::class);
    }

    function deleteAllByJobPostingId($jobPostingId) {
        return $this->model::where('job_posting_id', $jobPostingId)->delete();
    }
}
