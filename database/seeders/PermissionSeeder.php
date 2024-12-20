<?php

namespace Database\Seeders;

use App\Enums\EmployeeRolesEnum;
use App\Helpers\GetResourcesForPermissions;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->filamentPermissions();

        $resources = GetResourcesForPermissions::fetchResources();
        $resources->each(function ($resource) {
            GetResourcesForPermissions::createCrudPermissions($resource);
            GetResourcesForPermissions::syncPermissionsToAdmin();
        });

        $this->syncPermissionsToAdmin();

        $this->syncPermissionsToEmployee();

        $this->syncRoles();


    }

    private function syncRoles()
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@invoice.com',
            'password' => bcrypt('123456789'),
        ]);

        $admin->assignRole(EmployeeRolesEnum::Admin->value);

        $employee = User::factory()->create([
            'name' => 'Employee',
            'email' => 'employee@invoice.com',
            'password' => bcrypt('123456789'),
        ]);
        $employee->assignRole(EmployeeRolesEnum::Employee->value);

    }

    private function syncPermissionsToAdmin()
    {
        $role = Role::where('name', EmployeeRolesEnum::Admin)->first();

        $role->givePermissionTo(Permission::all());

        if (app()->isProduction()) {
            return;
        }

        $admin = User::role(EmployeeRolesEnum::Admin)->get();

        $admin->each(fn ($employee) => $employee->assignRole($role));
    }

    public function filamentPermissions(): void
    {
        $groups = [
            'Panel' => [
                'View Admin Panel'
            ],
        ];
        foreach ($groups as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'guard_name' => 'web',
                    'group' => $group,
                    'name' => $permission,
                ]);
            }
        }
    }

    private function syncPermissionsToEmployee()
    {
        $permissions = Permission::whereIn('name',['updateInvoice','viewAnyInvoice','viewInvoice'])->get();
        $employee = Role::where('name', EmployeeRolesEnum::Employee)->first();
        $employee->syncPermissions($permissions);
    }
}
