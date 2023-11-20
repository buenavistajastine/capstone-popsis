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
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-system-config']);
        Permission::create(['name' => 'edit-system-config']);
        Permission::create(['name' => 'delete-system-config']);

        Permission::create(['name' => 'create-appointments']);
        Permission::create(['name' => 'edit-appointments']);
        Permission::create(['name' => 'delete-appointments']);
        
        Permission::create(['name' => 'create-services']);
        Permission::create(['name' => 'edit-services']);
        Permission::create(['name' => 'delete-services']);
        
        Permission::create(['name' => 'create-booking']);
        Permission::create(['name' => 'edit-booking']);
        Permission::create(['name' => 'delete-booking']);
        
        Permission::create(['name' => 'create-assignment']);
        Permission::create(['name' => 'edit-assignment']);
        Permission::create(['name' => 'delete-assignment']);
        
        Permission::create(['name' => 'create-reports']);
        Permission::create(['name' => 'edit-reports']);
        Permission::create(['name' => 'delete-reports']);

        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $staffRole = Role::create(['name' => 'staff']);
        Role::create(['name' => 'customer']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-system-config',
            'edit-system-config',
            'delete-system-config',
            'create-appointments',
            'edit-appointments',
            'delete-appointments',
            'create-services',
            'edit-services',
            'delete-services',
            'create-booking',
            'edit-booking',
            'delete-booking',
            'create-assignment',
            'edit-assignment',
            'delete-assignment',
            'create-reports',
            'edit-reports',
            'delete-reports'
        ]);

        $managerRole->givePermissionTo([
            'create-users',
            'edit-users',
            'create-appointments',
            'edit-appointments',
            'delete-appointments'
        ]);

        $staffRole->givePermissionTo([
            'edit-system-config',
            'create-appointments',
            'edit-appointments',
            'delete-appointments',
            'create-booking',
            'edit-booking',
            'delete-booking',
        ]);
    }
}
