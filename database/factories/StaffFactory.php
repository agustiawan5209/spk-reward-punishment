<?php

namespace Database\Factories;

use App\Models\Departement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> User::factory(),
            'nama'=> function(array $attribute){
                return User::find($attribute['user_id'])->name;
            },
            'departement_id'=> Departement::factory(),
            // 'jabatan'=> fake()->randomElement(['Kepala Bagian', 'Kepala Sekretariat', 'Staff']),
            'jabatan'=> 'Staff',
            'alamat'=> fake()->address(),
        ];
    }
}
