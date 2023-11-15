<?php

namespace App\Services\user_access;

use App\Models\UserAccess;
use App\Services\GenericService;

class UserAccessService extends GenericService implements IUserAccessService
{
    public function __construct() {
        parent::__construct(UserAccess::class);
    }

    public function getAccessByUserId($userId) {
        return $this->model::where('user_id', $userId)->get();
    }
}
