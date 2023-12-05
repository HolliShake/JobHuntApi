<?php
namespace App\Services\file_profile;

use App\Models\FileProfile;
use App\Services\GenericService;

class FileProfileService extends GenericService implements IFileProfileService {
    function __construct() {
        parent::__construct(FileProfile::class);
    }

    function deleteByUserId($user_id) {
        return $this->model::where('user_id', $user_id)->delete();
    }
}
