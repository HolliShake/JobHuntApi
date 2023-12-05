<?php
namespace App\Services\file_cover;

use App\Models\FileCover;
use App\Services\GenericService;

class FileCoverService extends GenericService implements IFileCoverService {
    public function __construct() {
        parent::__construct(FileCover::class);
    }

    function deleteByUserId($user_id) {
        return $this->model::where('user_id', $user_id)->delete();
    }
}
