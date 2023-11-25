<?php
namespace App\Services\position;

use App\Models\Position;
use App\Services\GenericService;

class PositionService extends GenericService implements IPositionService {
    function __construct() {
        parent::__construct(Position::class);
    }

    function getPositionsByCompanyId($company_id) {
        return $this->model::with('salary')->with('office')->where('company_id', $company_id)->get();
    }

    function getCascadedPositionById($position_id) {
        return $this->model::with('salary')->with('office')->where('id', $position_id)->first();
    }
}
