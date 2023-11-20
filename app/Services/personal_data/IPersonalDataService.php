<?php
namespace App\Services\personal_data;

use App\Services\IGenericService;

interface IPersonalDataService extends IGenericService {
    function makeDefault($userId);
}
