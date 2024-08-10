<?php

namespace Database\Seeders;

use App\Models\AspekKriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AspekKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspek_kriterias = array(
            array(
                "id" => 1,
                "nama" => "Kriteria Penilaian",
                "persentase" => 100,
                "bobot" => 10,
                "core_factory" => 10,
                "secondary_factory" => 10,
                "created_at" => "2024-08-09 19:53:54",
                "updated_at" => "2024-08-10 01:33:42",
            ),
        );
        AspekKriteria::insert($aspek_kriterias);
    }
}
