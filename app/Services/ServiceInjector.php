<?php
namespace App\Services;

use App\Services\adtype\AdTypeService;
use App\Services\adtype\IAdTypeService;
use App\Services\application_log\ApplicationLogService;
use App\Services\application_log\IApplicationLogService;
use App\Services\company\CompanyService;
use App\Services\company\ICompanyService;
use App\Services\education\EducationService;
use App\Services\education\IEducationService;
use App\Services\file_banner\FileBannerService;
use App\Services\file_banner\IFileBannerService;
use App\Services\file_cover\FileCoverService;
use App\Services\file_cover\IFileCoverService;
use App\Services\file_profile\FileProfileService;
use App\Services\file_profile\IFileProfileService;
use App\Services\file_sample_photo\FileSamplePhotoService;
use App\Services\file_sample_photo\IFileSamplePhotoService;
use App\Services\hired_applicant\HiredApplicantService;
use App\Services\hired_applicant\IHiredApplicantService;
use App\Services\job_applicant\IJobApplicantService;
use App\Services\job_applicant\JobApplicantService;
use App\Services\job_posting\IJobPostingService;
use App\Services\job_posting\JobPostingService;
use App\Services\office\IOfficeService;
use App\Services\office\OfficeService;
use App\Services\personal_data\IPersonalDataService;
use App\Services\personal_data\PersonalDataService;
use App\Services\position\IPositionService;
use App\Services\position\PositionService;
use App\Services\rating\IRatingService;
use App\Services\rating\RatingService;
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
        $app->bind(IApplicationLogService::class, ApplicationLogService::class);
        $app->bind(ISkillService::class, SkillService::class);
        $app->bind(IUserService::class, UserService::class);
        $app->bind(IUserAccessService::class, UserAccessService::class);
        $app->bind(IPersonalDataService::class, PersonalDataService::class);
        $app->bind(IEducationService::class, EducationService::class);
        $app->bind(ICompanyService::class, CompanyService::class);
        $app->bind(ISalaryService::class, SalaryService::class);
        $app->bind(IPositionService::class, PositionService::class);
        $app->bind(IOfficeService::class, OfficeService::class);
        $app->bind(IAdTypeService::class, AdTypeService::class);
        $app->bind(IJobPostingService::class, JobPostingService::class);
        $app->bind(IRatingService::class, RatingService::class);
        $app->bind(IJobApplicantService::class, JobApplicantService::class);
        $app->bind(IHiredApplicantService::class, HiredApplicantService::class);
        $app->bind(IFileBannerService::class, FileBannerService::class);
        $app->bind(IFileSamplePhotoService::class, FileSamplePhotoService::class);
        $app->bind(IFileProfileService::class, FileProfileService::class);
        $app->bind(IFileCoverService::class, FileCoverService::class);
    }
}
