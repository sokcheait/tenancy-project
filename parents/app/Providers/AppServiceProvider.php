<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $routes = config('role-permission.permissions');
        foreach ($routes as $route) {
            $arr = collect($route);
            $arr->filter(function ($value, $key) {
                $permission = Permission::where('name', $key)->first();
                if (is_null($permission)) {
                    permission::create(['name' => $key]);
                }
                return $value;
            });
           
        }
        LogViewer::auth(function ($request) {
            return $request->user();
        });
    }
}
