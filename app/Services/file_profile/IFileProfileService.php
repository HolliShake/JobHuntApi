<?php
namespace App\Services\file_profile;

use App\Services\IGenericService;

interface IFileProfileService extends IGenericService {
    function deleteByUserId($user_id);
}
