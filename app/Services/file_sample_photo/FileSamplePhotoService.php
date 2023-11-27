<?php
namespace App\Services\file_sample_photo;

use App\Models\FileSamplePhoto;
use App\Services\GenericService;

class FileSamplePhotoService extends GenericService implements IFileSamplePhotoService
{
    public function __construct() {
        parent::__construct(FileSamplePhoto::class);
    }
}
