<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RegisterSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sokchea:register-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super admin';

    /**
     * User model.
     *
     * @var object
     */
    
    public function handle()
    {
        $input = [
            "name" => "Super Admin",
            "email" => "sokchea.superadmin@gmail.com",
            "password" => bcrypt("sokcheasuperadmin@123"),
            "password_confirmation" => bcrypt("sokcheasuperadmin@123"),
            "user_level" => 2,
        ];
        $users=app(User::class)->firstWhere('email',$input['email']);
        if(empty($users)){
            $superadminRole = Role::create(['name' => 'super-admin']);
            $user =User::create($input);
            $user->assignRole($superadminRole);
            $this->info('register super admin successfully.');
        }else{
            $this->info('register super admin already !');
        }
        
    }

}
