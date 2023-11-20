<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EducationController;
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
Route::controller(UserController::class)->group(function() {
    Route::get('/User/all', 'all');
    Route::put('/User/update/{user_id}', 'updateUser')->where('user_id', '\d*');
    Route::put('/User/delete/{user_id}', 'deleteUser')->where('user_id', '\d*');
});

// Skills
Route::controller(SkillController::class)->group(function() {
    Route::get('/Skill/all', 'all');
    Route::get('/Skill/User/{user_id}', 'getSkillsByUserId')->where('user_id', '\d*');
    Route::middleware('auth:api')->get('/Skill/My', 'getSkillsByLoggedInUser');
    Route::post('/Skill/create', 'createSkill');
    Route::put('/Skill/update/{skill_id}', 'updateSkill')->where('skill_id', '\d*');
    Route::delete('/Skill/delete/{skill_id}', 'deleteSkill')->where('skill_id', '\d*');
});

// Education
Route::controller(EducationController::class)->group(function() {
    Route::get('/Education/all', 'all');
    Route::get('/Education/User/{user_id}', 'getEducationsByUserId')->where('user_id', '\d*');
    Route::middleware('auth:api')->get('/Education/My', 'getEducationsByLoggedInUser');
    Route::post('/Education/create', 'createEducation');
    Route::put('/Education/update/{education_id}', 'updateEducation')->where('education_id', '\d*');
    Route::delete('/Education/delete/{education_id}', 'deleteEducation')->where('education_id', '\d*');
});

// Company
Route::controller(CompanyController::class)->group(function() {
    Route::get('/Company/Public/All', 'all');
    Route::get('/Company/{company_id}', 'getCompanyById')->where('company_id', '\d*');
    Route::middleware('auth:api')->get('/Company/My', 'myCompany');
    Route::post('/Company/create', 'createCompany');
    Route::put('/Company/update/{companyd_id}', 'updateCompany')->where('company_id', '\d*');
    Route::delete('/Company/delete/{companyd_id}', 'deleteCompany')->where('company_id', '\d*');
});

// User Access
Route::controller(UserAccessController::class)->group(function() {
    Route::get('/UserAccess/User/{user_id}', 'getUserAccessByUserId')->where('getUserAccessByUserId', '\d*');
    Route::post('/UserAccess/create', 'create');
});

