<?php

namespace App\Services;

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
    }
}
