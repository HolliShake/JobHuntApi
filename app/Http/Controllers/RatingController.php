<?php
namespace App\Http\Controllers;

use App\Services\rating\IRatingService;
use Illuminate\Support\Facades\Validator;

class RatingController extends ControllerBase
{
    function __construct(protected IRatingService $ratingService) {
    }

    function getSampleRatingByCompanyId($company_id) {
        return $this->ok($this->ratingService->getSampleRatingByCompanyId($company_id));
    }

    function getMyByCompanyId($company_id) {
        $user = request()->user();
        return $this->ok($this->ratingService->getMyByCompanyId($company_id, $user->id));
    }

    function addMyComment() {
        $validator = Validator::make(request()->all(), [
            'company_id' => 'required|integer',
            'rating' => 'required|integer',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $user = request()->user();
        $data = array_merge(request()->all(), [ 'user_id' => $user->id ]);

        $result = $this->ratingService->create($data);

        return ($result)
            ? $this->created($result)
            : $this->badRequest('');
    }
}
