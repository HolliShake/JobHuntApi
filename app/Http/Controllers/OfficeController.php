<?php

namespace App\Http\Controllers;

use App\Services\office\IOfficeService;
use Illuminate\Support\Facades\Validator;

class OfficeController extends ControllerBase
{
    //
    function __construct(private IOfficeService $officeService) {
    }

    function getOfficesByCompanyId($company_id) {
        return $this->ok($this->officeService->getOfficesByCompanyId($company_id));
    }

    function getOfficeById($office_id) {
        $office = $this->officeService->getById($office_id);
        return ($office)
            ? $this->ok($office)
            : $this->notFound('');
    }

    function createOffice() {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $office = $this->officeService->create(request()->all());

        return ($office)
            ? $this->created($office)
            : $this->badRequest('');
    }

    function updateOffice($office_id) {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $old = $this->officeService->getById($office_id);
        if (!$old) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $old, request()->all());
        $uresult = $this->officeService->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest('');
    }

    function deleteOffice($office_id) {
        $office = $this->officeService->getById($office_id);
        if (!$office) {
            return $this->notFound('');
        }

        $result = $this->officeService->delete($office);
        return ($result)
            ? $this->noContent()
            : $this->badRequest('');
    }

    function rules() {
        return [
            'name' => 'required|string|max:255',
            'country' => 'required|string',
            'address' => 'required|string|max:255',
            'mobile_number' => 'required|numeric',
            'company_id' => 'required|numeric'
        ];
    }
}
