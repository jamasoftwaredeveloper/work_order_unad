<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'title' => 'Super Admin',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Admin',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Reseller',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($roles);

        $admin_permissions = Permission::all();
        //Super Admin
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            $str = strpos($permission->title, 'index');
            return $str !== false;
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions->pluck('id')->toArray());

        //Admin
        $user_permissions = $admin_permissions->filter(function ($permission) {
            $str = strpos($permission->title, 'profile');
            return $str !== false;
        });
        Role::findOrFail(3)->permissions()->sync($user_permissions->pluck('id')->toArray());

        //Reseller
        $account_management = $admin_permissions->filter(function ($permission) {
            $str = strpos($permission->title, 'account_management');
            return $str !== false;
        });

        $register_operation = $admin_permissions->filter(function ($permission) {
            $str = strpos($permission->title, 'register_operation');
            return $str !== false;
        });

        $profile = $admin_permissions->filter(function ($permission) {
            $str = strpos($permission->title, 'profile');
            if ($str !== false) {
                return true;
            } else {
                return false;
            }
        });

        $permission = array_merge($account_management->pluck('id')->toArray(), $register_operation->pluck('id')->toArray(), $profile->pluck('id')->toArray());

        Role::findOrFail(3)->permissions()->sync($permission);
    }
}
