<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // aspek Permission
        Permission::create(['name' => 'add aspek']);
        Permission::create(['name' => 'edit aspek']);
        Permission::create(['name' => 'delete aspek']);
        Permission::create(['name' => 'show aspek']);
        // departement Permission
        Permission::create(['name' => 'add departement']);
        Permission::create(['name' => 'edit departement']);
        Permission::create(['name' => 'delete departement']);
        Permission::create(['name' => 'show departement']);

        // kriteria Permission
        Permission::create(['name' => 'add kriteria']);
        Permission::create(['name' => 'edit kriteria']);
        Permission::create(['name' => 'delete kriteria']);
        Permission::create(['name' => 'show kriteria']);
        Permission::create(['name' => 'reset kriteria']);


        // staff Permission
        Permission::create(['name' => 'add staff']);
        Permission::create(['name' => 'edit staff']);
        Permission::create(['name' => 'delete staff']);
        Permission::create(['name' => 'show staff']);
        Permission::create(['name' => 'reset staff']);
        // penilaian Permission
        Permission::create(['name' => 'add penilaian']);
        Permission::create(['name' => 'edit penilaian']);
        Permission::create(['name' => 'delete penilaian']);
        Permission::create(['name' => 'show penilaian']);
        Permission::create(['name' => 'reset penilaian']);

    }
}
