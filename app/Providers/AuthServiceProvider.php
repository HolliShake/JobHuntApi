<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Passport::setDefaultScope([
            'auth',
        ]);

        $MODULES = [
            'admin',
            'user',
        ];

        $OPERATION = [
            "all",
            "read",
            "write",
            "update",
            "delete",
        ];

        $rules = [];

        foreach ($MODULES as $module) {
            foreach ($OPERATION as $operation) {
                $rules["{$module}->{$operation}"] = ucfirst($operation) . " {$module}";
            }
        }

        Passport::tokensCan([
            'auth->view' => 'View',
            'all->all' => 'All',
            ...$rules,
        ]);
    }
}
