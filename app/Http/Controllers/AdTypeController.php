<?php
namespace App\Http\Controllers;

use App\Services\adtype\IAdTypeService;
use Illuminate\Support\Facades\Validator;

class AdTypeController extends ControllerBase
{
    function __construct(private IAdTypeService $adTypeService) {
    }

    function all() {
        return $this->ok($this->adTypeService->all());
    }

    function getAdTypeById($adtype_id) {
        $adtype = $this->adTypeService->getById($adtype_id);
        return ($adtype)
            ? $this->ok($adtype)
            : $this->notFound('');
    }

    function createAdType() {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $adtype = $this->adTypeService->create(request()->all());

        return ($adtype)
            ? $this->created($adtype)
            : $this->badRequest('');
    }

    function updateAdType($adtype_id) {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $old = $this->adTypeService->getById($adtype_id);
        if (!$old) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $old, request()->all());
        $uresult = $this->adTypeService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest('');
    }

    function deleteAdType($adtype_id) {
        $adtype = $this->adTypeService->getById($adtype_id);
        if (!$adtype) {
            return $this->notFound('');
        }

        $result = $this->adTypeService->delete($adtype_id);

        return ($result)
            ? $this->noContent('')
            : $this->badRequest('');
    }

    function rules() {
        return [
            'type' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'max_skills_matching' => 'required|integer|min:1|max:1000',
            'is_search_priority' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'is_analytics_available' => 'required|boolean',
            'is_editable' => 'required|boolean'
        ];
    }
}
