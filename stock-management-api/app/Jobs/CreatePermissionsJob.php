<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Permission;

class CreatePermissionsJob implements ShouldQueue
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
        $list_permissions = config('role-permission.permissions');
        foreach ($list_permissions as $permission) {
            $arr = collect($permission);
            $arr->filter(function ($value, $key) {
                $permiss = Permission::where('name', $key)->first();
                if (is_null($permiss)) {
                    permission::create(['name' => $key,'guard_name' => 'web']);
                }
            });
           
        }
    }
}
