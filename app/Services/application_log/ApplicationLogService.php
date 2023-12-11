<?php
namespace App\Services\application_log;

use App\Models\ApplicationLog;
use App\Services\GenericService;

class ApplicationLogService extends GenericService implements IApplicationLogService {
    function __construct() {
        parent::__construct(ApplicationLog::class);
    }
}
