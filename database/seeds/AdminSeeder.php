<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::findByName(User::ROLE_ADMIN);
        // All admin permission

        $permissions = Permission::all();

        //dd(Permission::findByName('View Help Requests'));

        // Creating admin User
        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'isActive' => '0',
            'role' => User::ROLE_ADMIN
        ]);
        
        $adminUser->save();
        $adminUser->assignRole($adminRole);
        
        $adminUser->givePermissionTo($permissions);
    }
}
