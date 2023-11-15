<?php
namespace App\Services\user_access;

use App\Services\IGenericService;

interface IUserAccessService extends IGenericService
{
    public function getAccessByUserId($userId);
}
