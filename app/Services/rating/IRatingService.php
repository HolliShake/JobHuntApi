<?php
namespace App\Services\rating;

use App\Services\IGenericService;

interface IRatingService extends IGenericService {
    function getSampleRatingByCompanyId($company_id);
    function getMyByCompanyId($company_id, $user_id);
}
