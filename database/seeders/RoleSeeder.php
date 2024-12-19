<?php

namespace Database\Seeders;

use App\Enums\EmployeeRolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = EmployeeRolesEnum::values();

        foreach ($data as $role) {
            Role::firstOrCreate(
                [
                    'name' => $role,
                    'guard_name' => 'web',
                ]
            );
        }
    }
}
