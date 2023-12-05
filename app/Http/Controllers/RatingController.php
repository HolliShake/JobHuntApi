<?php
namespace App\Http\Controllers;

use App\Services\rating\IRatingService;

class RatingController extends ControllerBase
{
    function __construct(protected IRatingService $ratingService) {
    }

    function getSampleRatingByCompanyId($company_id) {
        return $this->ok($this->ratingService->getSampleRatingByCompanyId($company_id));
    }
}
