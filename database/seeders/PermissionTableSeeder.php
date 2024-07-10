<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset permissions in cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permission
        $permissions = [
            'index',
            'show',
            'edit',
            'delete',
            'maintain',
            'administrate'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $roles = [
            'basic-user' => ['index', 'show'],
            'full-user' => ['index', 'show', 'edit', 'delete'],
            'maintainer' => ['index', 'show', 'edit', 'delete', 'maintain'],
            'admin' => ['index', 'show', 'edit', 'delete', 'maintain', 'administrate']
        ];

        foreach ($roles as $role => $rolePermissions) {
            $roleInstance = Role::create(['name' => $role]);
            $roleInstance->syncPermissions($rolePermissions);
        }

        // Reset permissions in cache again
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
