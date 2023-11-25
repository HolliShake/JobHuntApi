<?php
namespace App\Services;

use App\Services\company\CompanyService;
use App\Services\company\ICompanyService;
use App\Services\education\EducationService;
use App\Services\education\IEducationService;
use App\Services\office\IOfficeService;
use App\Services\office\OfficeService;
use App\Services\personal_data\IPersonalDataService;
use App\Services\personal_data\PersonalDataService;
use App\Services\position\IPositionService;
use App\Services\position\PositionService;
use App\Services\salary\ISalaryService;
use App\Services\salary\SalaryService;
use Illuminate\Foundation\Application;
use App\Services\skill\ISkillService;
use App\Services\skill\SkillService;
use App\Services\user\IUserService;
use App\Services\user\UserService;
use App\Services\user_access\IUserAccessService;
use App\Services\user_access\UserAccessService;

class ServiceInjector
{
    static function inject(Application $app)
    {
        $app->bind(ISkillService::class, SkillService::class);
        $app->bind(IUserService::class, UserService::class);
        $app->bind(IUserAccessService::class, UserAccessService::class);
        $app->bind(IPersonalDataService::class, PersonalDataService::class);
        $app->bind(IEducationService::class, EducationService::class);
        $app->bind(ICompanyService::class, CompanyService::class);
        $app->bind(ISalaryService::class, SalaryService::class);
        $app->bind(IPositionService::class, PositionService::class);
        $app->bind(IOfficeService::class, OfficeService::class);
    }
}
