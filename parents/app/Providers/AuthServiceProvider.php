<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // dd(config('role-permission.permissions'));

        // $routes = config('role-permission.permissions');

        // foreach ($routes as $route) {
        //     $arr = collect($route);
        //     $arr->filter(function ($value, $key) {
        //         dd($key);
        //         return $key;
        //     });
           
        // }
    }
}
