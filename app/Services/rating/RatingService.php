<?php
namespace App\Services\rating;

use App\Models\Rating;
use App\Services\GenericService;

class RatingService extends GenericService implements IRatingService {
    function __construct()
    {
        parent::__construct(Rating::class);
    }

    function getSampleRatingByCompanyId($company_id) {
        return $this->model::with([
            'user' => function($query) {
                $query->with('profile_image')->with('cover_image');
            }
        ])->where('company_id', $company_id)->orderBy('rating')->take(3)->get();
    }
}
