<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\Departement;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departement::factory(3)->afterCreating(function (Departement $departement) {
            User::factory(10)->afterCreating(function (User $user) use($departement) {
                $role = Role::findByName(fake()->randomElement(['Staff', 'Kepala Bagian'])); // Replace 'user' with your actual role name
                if ($role) {
                    $user->assignRole($role); // Assign 'user' role to the user
                }
                $user->givePermissionTo([
                    'show penilaian',
                    'show staff',
                ]);
                Staff::create([
                    'jabatan' => $role->name,
                    'user_id' => $user->id,
                    'departement_id' => $departement->id,
                    'nama' => $user->name,
                    'alamat' => fake()->address(),
                ]);
            })->create();
        })->create();
    }
}
