<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User
            ['title' => 'user_index', 'menu' => 'User', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'user_add', 'menu' => 'User', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'user_edit', 'menu' => 'User', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'user_delete', 'menu' => 'User', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Role
            ['title' => 'role_index', 'menu' => 'Role', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'role_add', 'menu' => 'Role', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'role_edit', 'menu' => 'Role', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'role_delete', 'menu' => 'Role', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Countries
            ['title' => 'country_index', 'menu' => 'Country', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'country_add', 'menu' => 'Country', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'country_edit', 'menu' => 'Country', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'country_delete', 'menu' => 'Country', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // States
            ['title' => 'state_index', 'menu' => 'State', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'state_add', 'menu' => 'State', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'state_edit', 'menu' => 'State', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'state_delete', 'menu' => 'State', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // City
            ['title' => 'city_index', 'menu' => 'City', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'city_add', 'menu' => 'City', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'city_edit', 'menu' => 'City', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'city_delete', 'menu' => 'City', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Document Type
            ['title' => 'document_type_index', 'menu' => 'Tipo de documento', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'document_type_add', 'menu' => 'Tipo de documento', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'document_type_edit', 'menu' => 'Tipo de documento', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'document_type_delete', 'menu' => 'Tipo de documento', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Work Order
            ['title' => 'work_order_index', 'menu' => 'Orden de trabajo', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'work_order_add', 'menu' => 'Orden de trabajo', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'work_order_edit', 'menu' => 'Orden de trabajo', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'work_order_delete', 'menu' => 'Orden de trabajo', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'work_order_show', 'menu' => 'Orden de trabajo', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            // Profile
            ['title' => 'profile_index', 'menu' => 'Profile', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'profile_edit', 'menu' => 'Profile', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'profile_delete', 'menu' => 'Profile', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
        ];

        Permission::insert($permissions);
    }
}
