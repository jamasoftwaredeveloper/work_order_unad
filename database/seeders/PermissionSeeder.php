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
            ['title' => 'document_type_index', 'menu' => 'Document type', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'document_type_add', 'menu' => 'Document type', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'document_type_edit', 'menu' => 'Document type', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'document_type_delete', 'menu' => 'Document type', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Work Order
            ['title' => 'work_order_index', 'menu' => 'WorkOrder', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'work_order_add', 'menu' => 'WorkOrder', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'work_order_edit', 'menu' => 'WorkOrder', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'work_order_delete', 'menu' => 'WorkOrder', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Profile
            ['title' => 'profile_index', 'menu' => 'Profile', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'profile_edit', 'menu' => 'Profile', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'profile_delete', 'menu' => 'Profile', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Account management
            ['title' => 'account_management_index', 'menu' => 'Account management', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'account_management_add', 'menu' => 'Account management', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'account_management_edit', 'menu' => 'Account management', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'account_management_delete', 'menu' => 'Account management', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            // Reseller management
            ['title' => 'reseller_management_index', 'menu' => 'Reseller management', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'reseller_management_add', 'menu' => 'Reseller management', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'reseller_management_edit', 'menu' => 'Reseller management', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'reseller_management_delete', 'menu' => 'Reseller management', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],
            //Register Operation
            ['title' => 'register_operation_index', 'menu' => 'Register Operation', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            //Credit Management
            ['title' => 'credit_management_index', 'menu' => 'Credit Management', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'credit_management_add', 'menu' => 'Credit Management', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'credit_management_edit', 'menu' => 'Credit Management', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now(),],
            ['title' => 'credit_management_delete', 'menu' => 'Credit Management', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now(),],


        ];

        Permission::insert($permissions);
    }
}
