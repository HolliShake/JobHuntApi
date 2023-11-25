<?php

namespace App\Services\adtype;

use App\Models\AdType;
use App\Services\GenericService;

class AdtypeService extends GenericService implements IAdTypeService {
    function __construct() {
        parent::__construct(AdType::class);
    }
}
