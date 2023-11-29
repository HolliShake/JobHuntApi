<?php

use App\Http\Controllers\AdTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
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
    Route::get('/Company/{company_id}', 'getCompanyById')->where('company_id', '\d+');
    Route::get('/Company/My', 'myCompany');
    Route::post('/Company/create', 'createCompany');
    Route::put('/Company/update/{companyd_id}', 'updateCompany')->where('company_id', '\d+');
    Route::delete('/Company/delete/{companyd_id}', 'deleteCompany')->where('company_id', '\d+');
});

// Salary
Route::middleware('auth:api')->controller(SalaryController::class)->group(function() {
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

// User Access
Route::middleware('auth:api')->controller(UserAccessController::class)->group(function() {
    Route::get('/UserAccess/User/{user_id}', 'getUserAccessByUserId')->where('getUserAccessByUserId', '\d+');
    Route::post('/UserAccess/create', 'create');
});

