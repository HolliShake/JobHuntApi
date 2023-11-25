<?php
namespace App\Services\office;

use App\Models\Office;
use App\Services\GenericService;

class OfficeService extends GenericService implements IOfficeService {
    function __construct() {
        parent::__construct(Office::class);
    }

    function getOfficesByCompanyId($company_id) {
        return $this->model::where('company_id', $company_id)->get();
    }
}
