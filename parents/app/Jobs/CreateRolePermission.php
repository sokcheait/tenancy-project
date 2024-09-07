<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Permission;

class CreateRolePermission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $routes = config('role-permission.permissions');
        foreach ($routes as $route) {
            $arr = collect($route);
            $arr->filter(function ($value, $key) {
                $permission = Permission::where('name', $key)->first();
                if (is_null($permission)) {
                    permission::create(['name' => $key,'guard_name'=>'web']);
                }
                return $value;
            });
        }
    }
}
