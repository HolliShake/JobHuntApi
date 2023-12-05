<?php
namespace App\Services\rating;

use App\Services\IGenericService;

interface IRatingService extends IGenericService {
    function getSampleRatingByCompanyId($company_id);
}
