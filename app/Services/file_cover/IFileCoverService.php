<?php
namespace App\Services\file_cover;

use App\Services\IGenericService;

interface IFileCoverService extends IGenericService {
    function deleteByUserId($user_id);
}
