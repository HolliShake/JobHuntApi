<?php
namespace App\Services\application_log;

use App\Models\ApplicationLog;
use App\Services\GenericService;
use Illuminate\Support\Facades\Date;

class ApplicationLogService extends GenericService implements IApplicationLogService {
    function __construct() {
        parent::__construct(ApplicationLog::class);
    }

    function getDashboardApplicationLogsByCompanyId($company_id) {
        return $this->model::with([
            'job_applicant' => function($query) {
                $query->with([
                    'job_posting' => function($query) {
                        $query->with([
                            'position' => function($query) {
                                $query->with('company');
                            }
                        ]);
                    }
                ]);
            }
        ])
        ->whereHas('job_applicant', function($query) use ($company_id) {
            $query->whereHas('job_posting', function($query) use ($company_id) {
                $query->whereHas('position', function($query) use ($company_id) {
                    $query->where('company_id', $company_id);
                });
            });
        })
        ->whereRaw('event_date >= ?', [Date::now()])
        ->get();
    }
}
