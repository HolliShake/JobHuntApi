<?php
namespace App\Services\file_sample_photo;

use App\Models\FileSamplePhoto;
use App\Services\GenericService;

class FileSamplePhotoService extends GenericService implements IFileSamplePhotoService
{
    public function __construct() {
        parent::__construct(FileSamplePhoto::class);
    }

    function deleteAllByJobPostingId($jobPostingId) {
        return $this->model::where('job_posting_id', $jobPostingId)->delete();
    }
}
