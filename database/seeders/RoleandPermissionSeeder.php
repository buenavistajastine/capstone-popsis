<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleandPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // For Sidebar
        Permission::create(['name' => 'user-management-access']);
        Permission::create(['name' => 'food-order-access']);
        Permission::create(['name' => 'booking-access']);
        Permission::create(['name' => 'kitchen-access']);
        Permission::create(['name' => 'billing-access']);
        Permission::create(['name' => 'report-access']);
        Permission::create(['name' => 'system-access']);
        Permission::create(['name' => 'authentication-access']);
        Permission::create(['name' => 'activity-logs-access']);

        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-system-config']);
        Permission::create(['name' => 'edit-system-config']);
        Permission::create(['name' => 'delete-system-config']);
        Permission::create(['name' => 'delete-system-logs']);

        Permission::create(['name' => 'create-booking']);
        Permission::create(['name' => 'edit-booking']);
        Permission::create(['name' => 'delete-booking']);

        Permission::create(['name' => 'create-order']);
        Permission::create(['name' => 'edit-order']);
        Permission::create(['name' => 'delete-order']);

        Permission::create(['name' => 'create-billing']);
        Permission::create(['name' => 'edit-billing']);
        Permission::create(['name' => 'delete-billing']);

        Permission::create(['name' => 'create-customer']);
        Permission::create(['name' => 'edit-customer']);
        Permission::create(['name' => 'delete-customer']);
        Permission::create(['name' => 'register-customer']);

        Permission::create(['name' => 'edit-kitchen']);
        Permission::create(['name' => 'print']);
        // Permission::create(['name' => 'create-reports']);
        // Permission::create(['name' => 'edit-reports']);
        
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $staffRole = Role::create(['name' => 'staff']);
        $kitchenstaffRole = Role::create(['name' => 'kitchen staff']);
        Role::create(['name' => 'customer']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-customer',
            'edit-customer',
            'delete-customer',
            'register-customer',
            'create-system-config',
            'edit-system-config',
            'delete-system-config',
            'create-order',
            'edit-order',
            'delete-order',
            'create-booking',
            'edit-booking',
            'delete-booking',
            'create-billing',
            'edit-billing',
            'delete-billing',
            'edit-kitchen',
            'print',
            'delete-system-logs',
            'user-management-access',
            'food-order-access',
            'booking-access',
            'billing-access',
            'report-access',
            'system-access',
            'authentication-access',
            'activity-logs-access'
        ]);

        $managerRole->givePermissionTo([
            'create-users',
            'edit-users',
            'create-booking',
            'edit-booking',
            'delete-booking',
            'create-order',
            'edit-order',
            'delete-order',
            'register-customer',
            'print'
        ]);

        $staffRole->givePermissionTo([
            'create-order',
            'edit-order',
            'create-booking',
            'edit-booking',
            'edit-kitchen',
        ]);

        $kitchenstaffRole->givePermissionTo([
            'edit-kitchen',
        ]);
    }
}
