<?php
namespace App\Services\user;

use App\Models\User;
use App\Services\GenericService;

class UserService extends GenericService implements IUserService {
    public function __construct() {
        parent::__construct(User::class);
    }

    function getById($id) {
        return User::with("user_access")->with('profile_image')->with('cover_image')->with([
            "personal_data" => function($query) {
                $query->with('education')->with('skill');
            }
        ])->where('id', $id)->first();
    }

    function getByEmail($email) {
        return User::with("user_access")->with('profile_image')->with('cover_image')->with([
            "personal_data" => function($query) {
                $query->with('education')->with('skill');
            }
        ])->where('email', $email)->first();
    }

    function getUserWithPersonalData($userId) {
        return User::with("user_access")->with('profile_image')->with('cover_image')->with([
            "personal_data" => function($query) {
                $query->with('education')->with('skill');
            }
        ])->where('id', $userId)->first();
    }
}

