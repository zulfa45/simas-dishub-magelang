<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $staf = Role::firstOrCreate(['name' => 'staf-loket']);
        $karyawan = Role::firstOrCreate(['name' => 'karyawan']);

        // Optional: Define basic permissions
        // Permission::firstOrCreate(['name' => 'surat.view']);
        // ... dll
    }
}
