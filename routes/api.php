<?php

use App\Http\Controllers\AdTypeController;
use App\Http\Controllers\ApplicationLogsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\FileCoverController;
use App\Http\Controllers\FileProfileController;
use App\Http\Controllers\HiredApplicantController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\UserController;
use App\Services\user\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request, IUserService $userService) {
    $user = $request->user();
    return $userService->getUserWithPersonalData($user->id);
});

// Auth
Route::controller(AuthController::class)->group(function() {
    Route::post('/Auth/login', 'login');
    Route::post('/Auth/register', 'register');
    Route::post('/Auth/generate/{secret}', 'generateAdmin')->where('secret', '.*');
});

// Users
Route::middleware('auth:api')->controller(UserController::class)->group(function() {
    Route::get('/User/all', 'all');
    Route::put('/User/update/{user_id}', 'updateUser')->where('user_id', '\d+');
    Route::put('/User/delete/{user_id}', 'deleteUser')->where('user_id', '\d+');
    Route::get('/User/Resume/{user_id}', 'getResumeByUserId')->where('user_id', '\d+');
    Route::get('/User/all/exceptcurrent', 'getAllUsersExceptCurrent');
    //
    Route::patch('/User/verify/{user_id}', 'verifyUser')->where('user_id', '\d+');
});

// Personal Data
Route::middleware('auth:api')->controller(PersonalDataController::class)->group(function() {
    Route::get('/PersonalData/all', 'all');
    Route::get('/PersonalData/My', 'getPersonalDataByLoggedInUser');
    Route::put('/PersonalData/update/{personal_data_id}', 'updatePersonalData')->where('personal_data_id', '\d+');
});

// Skills
Route::middleware('auth:api')->controller(SkillController::class)->group(function() {
    Route::get('/Skill/all', 'all');
    Route::get('/Skill/User/{user_id}', 'getSkillsByUserId')->where('user_id', '\d+');
    Route::get('/Skill/My', 'getSkillsByLoggedInUser');
    Route::post('/Skill/create', 'createSkill');
    Route::put('/Skill/update/{skill_id}', 'updateSkill')->where('skill_id', '\d+');
    Route::delete('/Skill/delete/{skill_id}', 'deleteSkill')->where('skill_id', '\d+');
});

// Education
Route::middleware('auth:api')->controller(EducationController::class)->group(function() {
    Route::get('/Education/all', 'all');
    Route::get('/Education/User/{user_id}', 'getEducationsByUserId')->where('user_id', '\d+');
    Route::get('/Education/My', 'getEducationsByLoggedInUser');
    Route::post('/Education/create', 'createEducation');
    Route::put('/Education/update/{education_id}', 'updateEducation')->where('education_id', '\d+');
    Route::delete('/Education/delete/{education_id}', 'deleteEducation')->where('education_id', '\d+');
});

// Company
Route::middleware('auth:api')->controller(CompanyController::class)->group(function() {
    Route::get('/Company/all', 'all');
    Route::get('/Company/partners/all', 'allPartners');
    Route::get('/Company/{company_id}', 'getCompanyById')->where('company_id', '\d+');
    Route::get('/Company/My', 'myCompany');
    Route::post('/Company/create', 'createCompany');
    Route::put('/Company/update/{companyd_id}', 'updateCompany')->where('company_id', '\d+');
    Route::delete('/Company/delete/{companyd_id}', 'deleteCompany')->where('company_id', '\d+');
    //
    Route::patch('/Company/accept/{company_id}', 'acceptCompany')->where('company_id', '\d+');
    Route::patch('/Company/reject/{company_id}', 'rejectCompany')->where('company_id', '\d+');
    Route::get('/Company/default', 'getDefaultCompany');
});

// Company Public
Route::controller(CompanyController::class)->group(function() {
    Route::get('/Company/Public/all', 'publicAllCompany');
    Route::get('/Company/Public/sample', 'getSampleCompanies');
});

// Salary
Route::middleware('auth:api')->controller(SalaryController::class)->group(function() {
    Route::get('/Salary/all', 'getAllSalaries');
    Route::get('/Salary/Company/{company_id}', 'getSalariesByCompanyId')->where('company_id', '\d+');
    Route::get('/Salary/{salary_id}', 'getSalaryById')->where('salary_id', '\d+');
    Route::post('/Salary/create', 'createSalary');
    Route::put('/Salary/update/{salary_id}', 'updateSalary')->where('salary_id', '\d+');
    Route::delete('/Salary/delete/{salary_id}', 'deleteSalary')->where('salary_id', '\d+');
});

// Office
Route::middleware('auth:api')->controller(OfficeController::class)->group(function() {
    Route::get('/Office/Company/{company_id}', 'getOfficesByCompanyId')->where('company_id', '\d+');
    Route::get('/Office/{office_id}', 'getOfficeById')->where('office_id', '\d+');
    Route::post('/Office/create', 'createOffice');
    Route::put('/Office/update/{office_id}', 'updateOffice')->where('office_id', '\d+');
    Route::delete('/Office/delete/{office_id}', 'deleteOffice')->where('office_id', '\d+');
});

// Position
Route::middleware('auth:api')->controller(PositionController::class)->group(function() {
    Route::get('/Position/Company/{company_id}', 'getPositionsByCompanyId')->where('company_id', '\d+');
    Route::get('/Position/cascade/{position_id}', 'getCascadedPositionById')->where('position_id', '\d+');
    Route::post('/Position/create', 'createPosition');
    Route::post('/Position/update/{position_id}', 'updatePosition')->where('position_id', '\d+');
    Route::delete('/Position/delete/{position_id}', 'deletePosition')->where('position_id', '\d+');
});

// Adtype
Route::middleware('auth:api')->controller(AdTypeController::class)->group(function() {
    Route::get('/Adtype/all', 'all');
    Route::get('/Adtype/{adtype_id}', 'getAdtypeById')->where('adtype_id', '\d+');
    Route::post('/Adtype/create', 'createAdtype');
    Route::put('/Adtype/update/{adtype_id}', 'updateAdtype')->where('adtype_id', '\d+');
    Route::delete('/Adtype/delete/{adtype_id}', 'deleteAdtype')->where('adtype_id', '\d+');
});

// JobPosting
Route::middleware('auth:api')->controller(JobPostingController::class)->group(function() {
    Route::get('/JobPosting/Company/{company_id}', 'getJobPostingByCompanyId')->where('company_id', '\d+');
    Route::post('/JobPosting/create', 'createJobPosting');
    Route::post('/JobPosting/update/{job_posting_id}', 'updateJobPosting')->where('job_posting_id', '\d+');
    Route::patch('/JobPosting/status/{job_posting_id}', 'updateJobPostingStatus')->where('job_posting_id', '\d+');
    Route::delete('/JobPosting/delete/{job_posting_id}', 'deleteJobPosting')->where('job_posting_id', '\d+');
});

// JobPosting Public
Route::controller(JobPostingController::class)->group(function() {
    Route::get('/JobPosting/Public/all', 'publicAllJobPosting');
    Route::get('/JobPosting/Public/{job_posting_id}', 'getJobPostingById')->where('job_posting_id', '\d+');
    Route::get('/JobPosting/Public/Company/{company_id}', 'getAllPublicJobPostingByCompanyId')->where('company_id', '\d+');
    Route::get('/JobPosting/Public/featured/sample', 'getSampleFeaturedJobPosting');
});

// Rating
Route::controller(RatingController::class)->group(function() {
    Route::get('/Rating/Sample/Company/{company_id}', 'getSampleRatingByCompanyId')->where('company_id', '\d+');
    Route::middleware('auth:api')->get('/Rating/Company/{company_id}', 'getMyByCompanyId')->where('company_id', '\d+');
    Route::middleware('auth:api')->post('/Rating/comment', 'addMyComment');
});

// FileProfile
Route::middleware('auth:api')->controller(FileProfileController::class)->group(function() {
    Route::post('/FileProfile/Change', 'changeDp');
});

// FileProfile
Route::middleware('auth:api')->controller(FileCoverController::class)->group(function() {
    Route::post('/FileCover/Change', 'changeCover');
});

// User Access
Route::middleware('auth:api')->controller(UserAccessController::class)->group(function() {
    Route::get('/UserAccess/User/{user_id}', 'getUserAccessByUserId')->where('getUserAccessByUserId', '\d+');
    Route::post('/UserAccess/create', 'create');
});

// JobApplication
Route::middleware('auth:api')->controller(JobApplicationController::class)->group(function() {
    Route::post('/JobApplication/apply/{job_posting_id}', 'applyJobPost')->where('job_posting_id', '\d+');
    Route::get('/JobApplication/JobPosting/{job_posting_id}', 'getJobApplicationByJobPostingId')->where('job_posting_id', '\d+');
    Route::get('/JobApplication/Dashboard/Company/{company_id}', 'getDashboardJobApplicationByCompanyId')->where('company_id', '\d+');
    Route::get('/JobApplication/Applications/My', 'myApplication');
    Route::get('/JobApplication/Applications/My/JobPosting/{job_posting_id}', 'myPendingApplicationByJobPosting')->where('job_posting_id', '\d+');
    Route::get('/JobApplication/{job_application_id}', 'getJobApplicationById')->where('job_application_id', '\d+');
    //
    Route::patch('/JobApplication/approve/{job_application_id}', 'approveJobApplication')->where('job_application_id', '\d+');
    Route::patch('/JobApplication/reject/{job_application_id}', 'rejectJobApplication')->where('job_application_id', '\d+');
    Route::delete('/JobApplication/cancel/{job_application_id}', 'deleteJobApplication')->where('job_application_id', '\d+');
});

// Application Logs
Route::middleware('auth:api')->controller(ApplicationLogsController::class)->group(function() {
    Route::post('/ApplicationLogs/create', 'createEventLog');
    Route::put('/ApplicationLogs/update/{application_log_id}', 'updateEventLog')->where('application_log_id', '\d+');
    Route::delete('/ApplicationLogs/delete/{application_log_id}', 'deleteEventLog')->where('application_log_id', '\d+');
    Route::patch('/ApplicationLogs/score/{application_log_id}', 'updateScore')->where('application_log_id', '\d+');
    Route::get('/ApplicationLogs/Dashboard/Company/{company_id}', 'getDashboardApplicationLogsByCompanyId')->where('company_id', '\d+');
});

// Employee
Route::middleware('auth:api')->controller(HiredApplicantController::class)->group(function() {
    Route::get('/Employee/Company/{company_id}', 'getEmployeeByCompanyId')->where('company_id', '\d+');
    Route::get('/Employee/My', 'getMyWork');
    Route::delete('/Employee/Delete/{hired_applicant_id}', 'deleteHiredApplicant')->where('hired_applicant_id', '\d+');
});
