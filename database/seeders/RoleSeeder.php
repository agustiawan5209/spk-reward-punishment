<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Admin']);
        $role_orangtua = Role::create(['name' => 'Kepala Bagian']);
        $role_staff = Role::create(['name' => 'Kepala Sekretariat']);

        $user = User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '123456780',
        ]);

        $user->assignRole($role);
        $user->givePermissionTo([
            'add staff',
            'edit staff',
            'delete staff',
            'show staff',

            'add kriteria',
            'edit kriteria',
            'delete kriteria',
            'show kriteria',
            'reset kriteria',

            'add aspek',
            'edit aspek',
            'delete aspek',
            'show aspek',

            'add departement',
            'edit departement',
            'delete departement',
            'show departement',
        ]);
    }
}
