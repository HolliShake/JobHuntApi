<?php
namespace App\Services\user;

use App\Models\User;
use App\Services\GenericService;

class UserService extends GenericService implements IUserService {
    public function __construct() {
        parent::__construct(User::class);
    }

    function getByEmail($email) {
        return User::with("user_access")->where('email', $email)->first();
    }
}

