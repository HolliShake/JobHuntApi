<?php
namespace App\Services\file_banner;

use App\Services\IGenericService;

interface IFileBannerService extends IGenericService {
    function deleteAllByJobPostingId($jobPostingId);
}
