<?php

namespace App\Http\Controllers;

use App\Services\position\IPositionService;
use Illuminate\Support\Facades\Validator;

class PositionController extends ControllerBase
{
    function __construct(protected readonly IPositionService $positionService)
    {
    }

    function getPositionsByCompanyId(int $company_id) {
        $positions = $this->positionService->getPositionsByCompanyId($company_id);

        return ($positions)
            ? $this->ok($positions)
            : $this->notFound('');
    }

    function createPosition() {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $position = $this->positionService->create(request()->all());
        return ($position)
            ? $this->created($position)
            : $this->badRequest('');
    }

    function updatePosition($position_id) {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $old = $this->positionService->getById($position_id);
        if (!$old) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $old, request()->all());
        $uresult = $this->positionService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest('');
    }

    function deletePosition($position_id) {
        $position = $this->positionService->getById($position_id);
        if (!$position) {
            return $this->notFound('');
        }

        $result = $this->positionService->delete($position);
        return ($result)
            ? $this->noContent()
            : $this->badRequest('');
    }

    function rules() {
        return [
            'title' => 'required|string',
            'slots' => 'required|integer|min:1',
            'description' => 'string',
            'employment_type' => 'required|string',
            'payment_type' => 'required|string',
            'skills' => 'required|string',
            'company_id' => 'required|integer',
            'salary_id' => 'required|integer'
        ];
    }
}
